<?php

namespace Toyi\MjmlBuilder\Statements\If;

use Closure;
use Toyi\MjmlBuilder\Components\ColumnComponent;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

class Condition
{
    public function __construct(
        protected Closure|string|array $success,
        public ?string $condition = null
    ) {
    }

    /**
     * Execute the condition.
     *
     * @param  ComponentAbstract|null  $parent
     * @return mixed
     */
    public function execute(ComponentAbstract $parent = null): mixed
    {
        if (! is_callable($this->success)) {
            $src = $this->success;

            $this->success = function (ComponentAbstract $column = null) use ($src): null|array|string {
                if (! $column instanceof ColumnComponent) {
                    return $src;
                }

                $column->text($src);

                return null;
            };
        }

        return ($this->success)($parent);
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }
}
