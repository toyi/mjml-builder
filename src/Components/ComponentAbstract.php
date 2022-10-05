<?php

namespace Toyi\MjmlBuilder\Components;

use Closure;
use Exception;
use Illuminate\Support\Str;
use Toyi\MjmlBuilder\Statements\Directive;
use Toyi\MjmlBuilder\Statements\ForeachStatement;
use Toyi\MjmlBuilder\Statements\If\IfStatement;

abstract class ComponentAbstract
{
    public string|array|null $content = null;

    protected string $id;

    protected array $attributes = [];

    protected array $children = [];

    protected array $childrenToPreprend = [];

    protected array $childrenToAppend = [];

    protected bool $isEndingTag = false;

    protected ?ComponentAbstract $parent = null;

    public function __construct(
        array $attributes = [],
        null|string|array $content = null,
        ?self $parent = null,
        string $id = null
    ) {
        $this->parent = $parent;
        $this->content = $content;
        $this->attributes = $attributes;

        $this->setId($id);
        $this->setParent($this->parent);
        $this->setAttributes($this->attributes);
    }

    abstract protected function tagName(): string;

    public function getChildren(): array
    {
        return $this->children;
    }

    public function pushChild(ComponentAbstract $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    public function prepend(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToPreprend[$id] = $this->addChild($component, $id);

        return $this;
    }

    public function append(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToAppend[$id] = $this->addChild($component, $id);

        return $this;
    }

    private function addChild(ComponentAbstract $component, string $id = null): ComponentAbstract
    {
        return $component->setId($id)->setParent($this, false);
    }

    private function remove(array &$pool, string $id): ComponentAbstract
    {
        $component = $pool[$id];
        $component->setParent(null);
        unset($pool[$id]);

        return $component;
    }

    public function removePrependedChild(string $id): ComponentAbstract
    {
        return $this->remove($this->childrenToPreprend, $id);
    }

    public function removeAppendedChild(string $id): ComponentAbstract
    {
        return $this->remove($this->childrenToAppend, $id);
    }

    public function isEndingTag(): bool
    {
        return $this->isEndingTag;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id = null): self
    {
        $this->id = $id ?: Str::uuid();

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?ComponentAbstract $parent, bool $pushToChildren = true): self
    {
        if ($parent === null) {
            return $this;
        }

        $this->parent = $parent;

        if ($pushToChildren) {
            $parent->pushChild($this);
        }

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            if (! is_int($key)) {
                continue;
            }

            $attributes[$value] = $value;
            unset($attributes[$key]);
        }

        $this->attributes = $attributes;

        return $this;
    }

    protected function getContent(): ?string
    {
        $content = (array) $this->content;
        $content = array_filter($content, fn (?string $content) => $content !== null);

        return implode('<br/>', $content);
    }

    public function raw(array|string $content, array $attributes = []): RawComponent
    {
        return new RawComponent($attributes, $content, $this);
    }

    public function if(IfStatement $if): self
    {
        return $this->directive($if);
    }

    public function foreach(ForeachStatement $foreach): self
    {
        return $this->directive($foreach);
    }

    public function directive(Directive $directive): self
    {
        if ($this->isEndingTag()) {
            $directive->inline();
        }

        $directive->generate($this);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function push(self|string $child): self
    {
        if (is_string($child)) {
            if (! class_exists($child)) {
                throw new Exception("Class $child doesn't exist.");
            }
            $child = new $child();
        }

        $child->setParent($this);

        return $child;
    }

    public function chain(Closure $chain): self
    {
        $chain($this);

        return $this;
    }

    public function toMjmlArray(): array
    {
        foreach ($this->childrenToPreprend as $child) {
            array_unshift($this->children, $child);
        }

        foreach ($this->childrenToAppend as $child) {
            $this->children[] = $child;
        }

        return array_filter([
            'tagName' => $this->tagName(),
            'attributes' => $this->attributes,
            'children' => array_map(fn ($child) => array_filter($child->toMjmlArray()), $this->getChildren()),
            'content' => $this->getContent(),
        ]);
    }
}
