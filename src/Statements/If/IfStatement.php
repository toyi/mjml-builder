<?php

namespace Toyi\MjmlBuilder\Statements\If;

use Closure;
use Toyi\MjmlBuilder\Components\ComponentAbstract;
use Toyi\MjmlBuilder\Statements\Directive;

class IfStatement extends Directive
{
    protected Condition $if;

    protected array $elseifs = [];

    protected ?Condition $else = null;

    public function __construct(string $condition, Closure|string|array $success)
    {
        $this->if = new Condition($success, $condition);
    }

    public function elseIf(string $condition, Closure|string|array $success): self
    {
        $this->elseifs[] = new Condition($success, $condition);

        return $this;
    }

    public function else(Closure|string|array $success): self
    {
        $this->else = new Condition($success);

        return $this;
    }

    public function generate(ComponentAbstract $parent = null): string
    {
        $str = $this->tag("<?php if({$this->if->getCondition()}){ ?>", $parent);
        $str .= $this->push($this->if->execute($parent), $parent);

        foreach ($this->elseifs as $elseif) {
            $str .= $this->tag("<?php }else if({$elseif->getCondition()}){ ?>", $parent);
            $str .= $this->push($elseif->execute($parent), $parent);
        }

        if ($this->else) {
            $str .= $this->tag('<?php }else{ ?>', $parent);
            $str .= $this->push($this->else->execute($parent), $parent);
        }

        $str .= $this->tag('<?php } ?>', $parent);

        return $str;
    }
}
