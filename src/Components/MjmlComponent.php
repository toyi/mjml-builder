<?php

namespace Toyi\MjmlBuilder\Components;

use Exception;

class MjmlComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mjml';
    }

    public function findChildById(string $component_id): ?self
    {
        /**
         * @throws Exception
         */
        $find_child_recursive = function (array $children) use ($component_id, &$find_child_recursive): ?self {
            foreach ($children as $child) {
                if ($child->id === $component_id) {
                    return $child;
                }

                return $find_child_recursive($child->getChildren());
            }

            throw new Exception("Unable to find component $component_id.");
        };

        return $find_child_recursive($this->getChildren());
    }
}
