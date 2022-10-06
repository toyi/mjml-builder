<?php

namespace Toyi\MjmlBuilder\Components;

class AllComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-all';
    }
}
