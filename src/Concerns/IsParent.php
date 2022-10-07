<?php

namespace Toyi\MjmlBuilder\Concerns;

use Toyi\MjmlBuilder\Components\ComponentAbstract;
use Toyi\MjmlBuilder\Exceptions\ParentException;

trait IsParent
{
    protected array $children = [];

    protected array $childrenToPreprend = [];

    protected array $childrenToAppend = [];

    protected bool $canHaveChildren = true;

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getPrependedChild(): array
    {
        return $this->childrenToPreprend;
    }

    public function getAppendedChild(): array
    {
        return $this->childrenToAppend;
    }

    /**
     * @throws ParentException
     */
    public function removeChild(ComponentAbstract $child): ComponentAbstract
    {
        $this->children = array_filter(
            $this->children,
            fn(ComponentAbstract $c) => $c->getId() !== $child->getId()
        );

        $child->setParent(null);

        return $child;
    }

    /**
     * @throws ParentException
     */
    public function push(string|ComponentAbstract $child): ComponentAbstract
    {
        if (is_string($child) && !class_exists($child)) {
            throw new ParentException("Class $child doesn't exist.");
        }

        if (!$this->canHaveChildren) {
            throw new ParentException($this::class . ' cannot have children.');
        }

        if (is_string($child)) {
            $child = new $child();
        }

        $this->children[] = $child;

        if ($this->getParent() !== $this) {
            $child->setParent($this, false);
        }

        return $child;
    }

    public function prependChild(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToPreprend[$id] = $this->addChild($component, $id);

        return $this;
    }

    public function appendChild(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToAppend[$id] = $this->addChild($component, $id);

        return $this;
    }

    private function addChild(ComponentAbstract $component, string $id = null): ComponentAbstract
    {
        return $component->setId($id)->setParent($this, false);
    }

    private function removeChildFromPool(array &$pool, string $id): ComponentAbstract
    {
        $component = $pool[$id];
        $component->setParent(null);
        unset($pool[$id]);

        return $component;
    }

    public function unPrependChild(string $id): ComponentAbstract
    {
        return $this->removeChildFromPool($this->childrenToPreprend, $id);
    }

    public function unAppendChild(string $id): ComponentAbstract
    {
        return $this->removeChildFromPool($this->childrenToAppend, $id);
    }
}
