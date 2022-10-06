<?php

namespace Toyi\MjmlBuilder\Statements;

use Closure;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

class ForeachStatement extends Statement
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
        $str = '';

        if ($this->empty) {
            $str .= $this->tag("<?php if(count($this->iterable) === 0){ ?>", $parent);
            $str .= $this->push(($this->empty)($parent), $parent);
            $str .= $this->tag('<?php }else{ ?>', $parent);
        }

        $str .= $this->tag("<?php foreach($this->iterable as $$this->key => $$this->value){ ?>", $parent);

        $str .= $this->push(($this->loop)($parent), $parent);

        $str .= $this->tag('<?php } ?>', $parent);

        if ($this->empty) {
            $str .= $this->tag('<?php } ?>', $parent);
        }

        return $str;
    }
}
