<?php

namespace Toyi\MjmlBuilder\Components;

use Closure;
use Exception;
use Toyi\MjmlBuilder\Concerns\HasAttributes;
use Toyi\MjmlBuilder\Concerns\IsChild;
use Toyi\MjmlBuilder\Concerns\IsParent;
use Toyi\MjmlBuilder\Statements\Directive;
use Toyi\MjmlBuilder\Statements\ForeachStatement;
use Toyi\MjmlBuilder\Statements\If\IfStatement;

abstract class ComponentAbstract
{
    use IsParent, IsChild, HasAttributes;

    public string|array|null $content = null;

    protected bool $isEndingTag = false;

    /**
     * @throws Exception
     */
    public function __construct(
        array             $attributes = [],
        null|string|array $content = null,
        ?self             $parent = null,
        string            $id = null
    )
    {

        $this->setContent($content);
        $this->setParent($parent);
        $this->setId($id);
        $this->setAttributes($attributes);
    }

    abstract protected function tagName(): string;

    public function isEndingTag(): bool
    {
        return $this->isEndingTag;
    }

    public function setContent(null|string|array $content = null): self
    {
        if (!$this->isEndingTag() && is_array($content)) {
            $content = implode('', $content);
        }

        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        if (!$this->isEndingTag()) {
            return (string)$this->content;
        }

        $content = (array)$this->content;
        $content = array_filter($content, fn(?string $content) => $content !== null);

        return implode('<br/>', $content);
    }

    /**
     * @throws Exception
     */
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
            $child->setParent($this);
        }

        return array_filter([
            'tagName' => $this->tagName(),
            'attributes' => $this->attributes,
            'children' => array_map(fn(ComponentAbstract $child) => array_filter($child->toMjmlArray()), $this->getChildren()),
            'content' => $this->getContent(),
        ]);
    }
}
