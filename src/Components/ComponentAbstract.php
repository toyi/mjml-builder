<?php

namespace Toyi\MjmlBuilder\Components;

use Closure;
use Exception;
use Illuminate\Support\Str;
use Toyi\MjmlBuilder\Blade\Directive;
use Toyi\MjmlBuilder\Blade\ForeachDirective;
use Toyi\MjmlBuilder\Blade\If\IfDirective;

abstract class ComponentAbstract
{
    public string|array|null $content = null;

    protected string $id;

    public array $children = [];

    protected bool $isPlain = false;

    protected array $attributes = [];

    protected ?ComponentAbstract $parent = null;

    public function __construct(
        array             $attributes = [],
        null|string|array $content = null,
        ?self             $parent = null,
        string            $id = null
    )
    {
        $this->parent = $parent;
        $this->content = $content;
        $this->attributes = $attributes;

        $this->setId($id);
        $this->setParent($this->parent);
        $this->setAttributes($this->attributes);
    }

    protected function tagName(): string
    {
        return Str::of(static::class)->classBasename()->replaceLast('Component', '')->kebab()->prepend('mj-')->toString();
    }

    public function isPlain(): bool
    {
        return $this->isPlain;
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

    public function setParent(?self $parent, bool $pushToChildren = true): self
    {
        if ($parent === null) {
            return $this;
        }

        $this->parent = $parent;

        if ($pushToChildren) {
            $parent->children[] = $this;
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
            if (!is_int($key)) {
                continue;
            }

            $attributes[$value] = $value;
            unset($attributes[$key]);
        }

        $this->attributes = $attributes;

        return $this;
    }

    public function findChildByComponentId(string $component_id): ?self
    {
        /**
         * @throws Exception
         */
        $find_child_recursive = function (array $children) use ($component_id, &$find_child_recursive): ?self {
            foreach ($children as $child) {
                if ($child->id === $component_id) {
                    return $child;
                }

                return $find_child_recursive($child->children);
            }

            throw new Exception("Unable to find component $component_id.");
        };

        return $find_child_recursive($this->children);
    }

    protected function getContent(): ?string
    {
        $content = (array)$this->content;
        $content = array_filter($content, fn(?string $content) => $content !== null);

        return implode('<br/>', $content);
    }

    public function raw(array|string $content, array $attributes = []): RawComponent
    {
        return new RawComponent($attributes, $content, $this);
    }

    public function if(IfDirective $if): self
    {
        return $this->directive($if);
    }

    public function foreach(ForeachDirective $foreach): self
    {
        return $this->directive($foreach);
    }

    public function directive(Directive $directive): self
    {
        if ($this->isPlain()) {
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
            if (!class_exists($child)) {
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
        return array_filter([
            'tagName' => $this->tagName(),
            'attributes' => $this->attributes,
            'children' => array_map(fn($child) => array_filter($child->toMjmlArray()), $this->children),
            'content' => $this->getContent(),
        ]);
    }
}
