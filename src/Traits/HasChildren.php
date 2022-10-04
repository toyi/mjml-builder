<?php

namespace Toyi\MjmlBuilder\Traits;

use Toyi\MjmlBuilder\Components\ComponentAbstract;

trait HasChildren
{
    protected array $childrenToPreprend = [];

    protected array $childrenToAppend = [];

    public function prepend(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToPreprend[$id] = $this->add($component, $id);

        return $this;
    }

    public function append(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToAppend[$id] = $this->add($component, $id);

        return $this;
    }

    private function add(ComponentAbstract $component, string $id = null): ComponentAbstract
    {
        return $component->setId($id)->setParent($this, false);
    }

    private function removeFromPool(array &$pool, $id): void
    {
        unset($pool[$id]);
    }

    private function remove(array &$pool, string $id): ComponentAbstract
    {
        $component = $pool[$id];
        $component->setParent(null);
        $this->removeFromPool($pool, $id);

        return $component;
    }

    public function removePrepend(string $id): ComponentAbstract
    {
        return $this->remove($this->childrenToPreprend, $id);
    }

    public function removeAppend(string $id): ComponentAbstract
    {
        return $this->remove($this->childrenToAppend, $id);
    }

    public function toMjmlArray(): array
    {
        foreach ($this->childrenToPreprend as $id => $child) {
            array_unshift($this->children, $child);
//            $this->removeFromPool($this->childrenToPreprend, $id);
        }

        foreach ($this->childrenToAppend as $id => $child) {
            $this->children[] = $child;
//            $this->removeFromPool($this->childrenToAppend, $id);
        }

        return parent::toMjmlArray();
    }
}
