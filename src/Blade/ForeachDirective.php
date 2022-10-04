<?php

namespace Toyi\MjmlBuilder\Blade;

use Closure;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

class ForeachDirective extends Directive
{
    protected ?Closure $empty = null;

    protected ?ComponentAbstract $parent = null;

    public function __construct(
        protected string $iterable,
        protected Closure $loop,
        protected string $value = 'value',
        protected string $key = 'key'
    ) {
    }

    public function empty(Closure $closure): self
    {
        $this->empty = $closure;

        return $this;
    }

    public function generate(ComponentAbstract $parent = null): string
    {
        $type = $this->empty ? 'forelse' : 'foreach';

        $str = $this->tag("@$type($this->iterable as $$this->key => $$this->value)", $parent);

        $str .= $this->push(($this->loop)($parent), $parent);

        if ($this->empty) {
            $str = $this->tag('@empty', $parent);
            $str .= $this->push(($this->empty)($parent), $parent);
        }

        $str .= $this->tag("@end$type", $parent);

        return $str;
    }
}
