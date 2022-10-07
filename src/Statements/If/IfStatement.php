<?php

namespace Toyi\MjmlBuilder\Statements\If;

use Closure;
use Toyi\MjmlBuilder\Components\ComponentAbstract;
use Toyi\MjmlBuilder\Statements\Statement;

class IfStatement extends Statement
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

    protected function handle(ComponentAbstract $component = null): string
    {
        $str = $this->tag("<?php if({$this->if->getCondition()}){ ?>", $component);
        $str .= $this->push($this->if->execute($component), $component);

        foreach ($this->elseifs as $elseif) {
            $str .= $this->tag("<?php }else if({$elseif->getCondition()}){ ?>", $component);
            $str .= $this->push($elseif->execute($component), $component);
        }

        if ($this->else) {
            $str .= $this->tag('<?php }else{ ?>', $component);
            $str .= $this->push($this->else->execute($component), $component);
        }

        $str .= $this->tag('<?php } ?>', $component);

        return $str;
    }
}
