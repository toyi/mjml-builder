<?php

namespace Toyi\MjmlBuilder\Statements\If;

use Closure;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

class Condition
{
    public function __construct(
        protected Closure|string|array $success,
        public ?string $condition = null
    ) {
        if (! is_callable($this->success)) {
            $src = $this->success;
            $this->success = fn () => $src;
        }
    }

    public function execute(ComponentAbstract $parent = null): mixed
    {
        return ($this->success)($parent);
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }
}
