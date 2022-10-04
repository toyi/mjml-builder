<?php

namespace Toyi\MjmlBuilder\Blade;

use Toyi\MjmlBuilder\Components\ComponentAbstract;

abstract class Directive
{
    protected bool $inline = false;

    public static function make(mixed ...$args): static
    {
        return new static(...$args);
    }

    abstract public function generate(ComponentAbstract $parent = null): string;

    public function inline(): self
    {
        $this->inline = true;

        return $this;
    }

    protected function tag(string $tag, ComponentAbstract $parent = null): string
    {
        $tag = "\n$tag\n";

        if (! $this->inline) {
            $tag .= '&nbsp;';
        }

        return $this->push($tag, $parent, $parent !== null);
    }

    protected function push(array|string $str = null, ComponentAbstract $parent = null, bool $raw = false): string
    {
        if (is_array($str)) {
            $str = implode('<br />', $str);
        }

        if ($parent) {
            if ($parent->isPlain()) {
                $parent->content .= $str;
            } elseif ($raw) {
                $parent->raw($str);
            }
        }

        return $str ?: '';
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}
