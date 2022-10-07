<?php

namespace Toyi\MjmlBuilder\Statements;

use Closure;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

class ForeachStatement extends Statement
{
    /**
     * Executed when the iterable count === 0 instead of doing nothing.
     *
     * @var Closure|null
     */
    protected ?Closure $empty = null;

    public function __construct(
        protected string $iterable,
        protected string|Closure $loop,
        protected string $value = 'value',
        protected string $key = 'key'
    ) {
    }

    public function empty(Closure $closure): self
    {
        $this->empty = $closure;

        return $this;
    }

    protected function handle(ComponentAbstract $component = null): string
    {
        $str = '';

        if ($this->empty) {
            $str .= $this->tag("<?php if(count($this->iterable) === 0){ ?>", $component);
            $str .= $this->push(($this->empty)($component), $component);
            $str .= $this->tag('<?php }else{ ?>', $component);
        }

        $str .= $this->tag("<?php foreach($this->iterable as $$this->key => $$this->value){ ?>", $component);

        $loop = $this->loop;
        if (is_string($loop)) {
            $this->loop = function (ComponentAbstract $component = null) use ($loop) {
                if ($component === null || ! method_exists($component, 'text')) {
                    return $loop;
                }

                $component->text($loop);

                return null;
            };
        }

        $str .= $this->push(($this->loop)($component), $component);

        $str .= $this->tag('<?php } ?>', $component);

        if ($this->empty) {
            $str .= $this->tag('<?php } ?>', $component);
        }

        return $str;
    }
}
