<?php

namespace Toyi\MjmlBuilder\Concerns;

use Exception;
use Toyi\MjmlBuilder\Components\ComponentAbstract;

trait IsChild
{
    protected ?ComponentAbstract $parent = null;

    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @throws Exception
     */
    public function setParent(?ComponentAbstract $parent, bool $pushToChildren = true): self
    {
        if ($parent === null) {
            $this->parent = null;
            return $this;
        }

        $this->parent = $parent;

        if ($pushToChildren) {
            $parent->push($this);
        }

        return $this;
    }
}
