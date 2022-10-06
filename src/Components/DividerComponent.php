<?php

namespace Toyi\MjmlBuilder\Components;

class DividerComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-divider';
    }
}
