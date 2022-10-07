<?php

namespace Toyi\MjmlBuilder\Concerns;

use Toyi\MjmlBuilder\Components\ComponentAbstract;
use Toyi\MjmlBuilder\Exceptions\ParentException;

trait IsChild
{
    protected ?ComponentAbstract $parent = null;

    /**
     * The parent of this component.
     *
     * @return ComponentAbstract|null
     */
    public function getParent(): ?ComponentAbstract
    {
        return $this->parent;
    }

    /**
     * Set the parent of this component.
     *
     * @param  ComponentAbstract|null  $parent
     * @param  bool  $pushToChildren
     * @return IsChild|ComponentAbstract
     *
     * @throws ParentException
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
