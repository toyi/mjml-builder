<?php

namespace Toyi\MjmlBuilder\Components;

class ClassComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-class';
    }
}
