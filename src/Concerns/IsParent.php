<?php

namespace Toyi\MjmlBuilder\Concerns;

use Exception;
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
     * Remove a child from the children list.
     *
     * @throws ParentException
     */
    public function removeChild(ComponentAbstract $child): ComponentAbstract
    {
        $this->children = array_filter(
            $this->children,
            fn (ComponentAbstract $c) => $c->getId() !== $child->getId()
        );

        $child->setParent(null);

        return $child;
    }

    /**
     * Recursively search for a child with the given id
     *
     * @param  string  $id
     * @return ComponentAbstract|null
     */
    public function findChildById(string $id): ?ComponentAbstract
    {
        /**
         * @throws Exception
         */
        $fct = function (array $children) use ($id, &$fct) {
            foreach ($children as $child) {
                if ($child->id === $id) {
                    return $child;
                }

                $res = $fct($child->getChildren());

                if ($res !== null) {
                    return $res;
                }
            }

            return null;
        };

        return $fct($this->getChildren());
    }

    /**
     * Push a child to the children list.
     * Can be usefull to push a custom component that doesn't have a dedicated builtin method.
     *
     * @throws ParentException
     */
    public function push(string|ComponentAbstract $child): ComponentAbstract
    {
        if (is_string($child) && ! class_exists($child)) {
            throw new ParentException("Class $child doesn't exist.");
        }

        if (! $this->canHaveChildren) {
            throw new ParentException($this::class.' cannot have children.');
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

    /**
     * Prepending a child will ensure it's always added before any other pushed child.
     *
     * @param ComponentAbstract $component
     * @param string|null $id
     * @return ComponentAbstract|IsParent
     */
    public function prependChild(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToPreprend[$id] = $this->addChild($component, $id);

        return $this;
    }

    /**
     * Appending a child will ensure it's always added at the end of the children list.
     * For instance, the signature at the end of a template..
     *
     * @param ComponentAbstract $component
     * @param string|null $id
     * @return ComponentAbstract|IsParent
     */
    public function appendChild(ComponentAbstract $component, string $id = null): self
    {
        $this->childrenToAppend[$id] = $this->addChild($component, $id);

        return $this;
    }

    /**
     * Remove a child from the prepend list.
     *
     * @param string $id
     * @return ComponentAbstract
     */
    public function unPrependChild(string $id): ComponentAbstract
    {
        return $this->removeChildFromPool($this->childrenToPreprend, $id);
    }

    /**
     * Remove a child from the append list.
     *
     * @param string $id
     * @return ComponentAbstract
     */
    public function unAppendChild(string $id): ComponentAbstract
    {
        return $this->removeChildFromPool($this->childrenToAppend, $id);
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
}
