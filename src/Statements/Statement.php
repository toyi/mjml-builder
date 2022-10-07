<?php

namespace Toyi\MjmlBuilder\Statements;

use Exception;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

abstract class Statement
{
    /**
     * When a statement is inline, there will be no spaces between php tags
     * and no <!-- htmlmin:ignore --> comments. This is meant to be used inside a string.
     *
     * @var bool
     */
    protected bool $inline = false;

    public static function make(mixed ...$args): static
    {
        return new static(...$args);
    }

    /**
     * Generate the statement.
     * If the component argument is not null and is an endingTag, the inline property
     * is forced to true.
     *
     * @param ComponentAbstract|null $component
     * @return string
     */
    public function generate(ComponentAbstract $component = null): string
    {
        if ($component?->isEndingTag()) {
            $this->inline();
        }

        return $this->handle($component);
    }

    /**
     * The actual behavior of the statement.
     * In this method, the content is pushed, the mj-raw children are created...
     *
     * @return string
     */
    abstract protected function handle(): string;

    public function inline(): self
    {
        $this->inline = true;

        return $this;
    }

    /**
     * Needed to prevent the MJML minifier to throw parsing errors.
     * https://documentation.mjml.io/#mj-raw
     *
     * @param string $content
     * @return string
     */
    protected function ignoreContent(string $content): string
    {
        return "<!-- htmlmin:ignore -->$content<!-- htmlmin:ignore -->";
    }

    /**
     * @throws Exception
     */
    protected function tag(string $tag, ComponentAbstract $component = null): string
    {
        $tag = "\n$tag\n";

        if (!$this->inline) {
            $tag = $this->ignoreContent($tag);
            $tag .= '&nbsp;';
        }

        return $this->push($tag, $component, $component !== null);
    }

    /**
     * Push the given string to the content of a component.
     *
     * If the given content is an array, it's imploded to a string using <br /> as glue.
     *
     * Then...
     * If the component is an ending tag, the given content will be appended at the end.
     * If it's not an ending tag, it'll be pushed as a mj-raw child.
     *
     * @param array|string|null $str
     * @param ComponentAbstract|null $component
     * @param bool $raw
     * @return string
     * @throws Exception
     */
    protected function push(array|string $str = null, ComponentAbstract $component = null, bool $raw = false): string
    {
        if (is_array($str)) {
            $str = implode('<br />', $str);
        }

        if ($component) {
            if ($component->isEndingTag()) {
                $component->pushContent($str);
            } elseif ($raw) {
                $component->raw($str);
            }
        }

        return $str ?: '';
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}
