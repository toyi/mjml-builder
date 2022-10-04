<?php

namespace Toyi\MjmlBuilder\Blade\If;

use Closure;
use stdClass;
use Toyi\MjmlBuilder\Blade\Directive;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

class IfDirective extends Directive
{
    protected IfStatement $if;

    protected array $elseifs = [];

    protected ?IfStatement $else = null;

    public function __construct(string $condition, Closure|string|array $success)
    {
        $this->if = new IfStatement($success, $condition);
    }

    public function elseIf(string $condition, Closure|string|array $success): self
    {
        $this->elseifs[] = new IfStatement($success, $condition);

        return $this;
    }

    public function else(Closure|string|array $success): self
    {
        $this->else = new IfStatement($success);

        return $this;
    }

    public function generate(ComponentAbstract $parent = null): string
    {
        $str = $this->tag("@if({$this->if->getCondition()})", $parent);
        $str .= $this->push($this->if->execute($parent), $parent);

        foreach ($this->elseifs as $elseif) {
            $str .= $this->tag("@elseif({$elseif->getCondition()})", $parent);
            $str .= $this->push($elseif->execute($parent), $parent);
        }

        if ($this->else) {
            $str .= $this->tag('@else', $parent);
            $str .= $this->push($this->else->execute($parent), $parent);
        }

        $str .= $this->tag('@endif', $parent);

        return $str;
    }
}
