<?php

namespace Toyi\MjmlBuilder\Components;

use Exception;

class MjmlComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mjml';
    }

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
}
