<?php

namespace Toyi\MjmlBuilder\Components;

use Closure;
use Exception;
use Toyi\MjmlBuilder\Concerns\HasAttributes;
use Toyi\MjmlBuilder\Concerns\IsChild;
use Toyi\MjmlBuilder\Concerns\IsParent;
use Toyi\MjmlBuilder\Statements\ForeachStatement;
use Toyi\MjmlBuilder\Statements\If\IfStatement;
use Toyi\MjmlBuilder\Statements\Statement;

abstract class ComponentAbstract
{
    use IsParent, IsChild, HasAttributes;

    /**
     * The content represents the text or html inside this component.
     *
     * @var string|array|null
     */
    protected string|array|null $content = null;

    protected string $contentGlue = '<br />';

    /**
     * Is this an ending tag ? (https://documentation.mjml.io/#ending-tags)
     *
     * @var bool
     */
    protected bool $isEndingTag = false;

    public function __construct(
        array $attributes = [],
        null|string|array $content = null,
        ?self $parent = null,
        string $id = null
    ) {
        $this->setParent($parent);
        $this->setContent($content);
        $this->setId($id);
        $this->setAttributes($attributes);
    }

    abstract protected function tagName(): string;

    public function isEndingTag(): bool
    {
        return $this->isEndingTag;
    }

    public function contentGlue(string $glue): self
    {
        $this->contentGlue = $glue;

        return $this;
    }

    public function noContentGlue(): self
    {
        $this->contentGlue = '';

        return $this;
    }

    public function setContent(null|string|array $content = null): self
    {
        if (! $this->isEndingTag() && is_array($content)) {
            $content = implode('', $content);
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Push (append) a string to the current content.
     * If the content is a string, the addition will be concatenated.
     * If it's an array, it'll be pushed as new value.
     *
     * @param  string|null  $contentToPush
     * @return $this
     */
    public function pushContent(?string $contentToPush): self
    {
        if (is_array($this->content)) {
            $this->content[] = $contentToPush;
        } else {
            $this->content .= $contentToPush;
        }

        return $this;
    }

    /**
     * Get the content of this component.
     * If the component is an ending tag and the content an array,
     * it'll be casted as a string where every new line is a <br />
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        if (! $this->isEndingTag()) {
            return (string) $this->content;
        }

        $content = (array) $this->content;
        $content = array_filter($content, fn (?string $content) => $content !== null);

        return implode($this->contentGlue, $content);
    }

    /**
     * Add a child mj-raw component.
     * https://documentation.mjml.io/#mj-raw
     *
     * @throws Exception
     */
    public function raw(array|string $content, array $attributes = []): RawComponent
    {
        return new RawComponent($attributes, $content, $this);
    }

    /**
     * Add an if statement to the content of this component
     *
     * @param  IfStatement  $if
     * @return $this
     */
    public function if(IfStatement $if): self
    {
        return $this->statement($if);
    }

    /**
     * Add a foreach statement to the content of this component
     *
     * @param  ForeachStatement  $foreach
     * @return $this
     */
    public function foreach(ForeachStatement $foreach): self
    {
        return $this->statement($foreach);
    }

    protected function statement(Statement $directive): self
    {
        $directive->generate($this);

        return $this;
    }

    /**
     * Chaining is useful to keep a "xml like" structured code.
     * It takes a closure with the component itself as argument.
     *
     * @param  Closure  $chain
     * @return $this
     */
    public function chain(Closure $chain): self
    {
        $chain($this);

        return $this;
    }

    /**
     * Convert a component into an array following the MJML JSON structure
     *
     * @return array
     */
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
            'children' => array_map(fn (ComponentAbstract $child) => array_filter($child->toMjmlArray()), $this->getChildren()),
            'content' => $this->getContent(),
        ]);
    }
}
