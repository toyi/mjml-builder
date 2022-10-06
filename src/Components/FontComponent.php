<?php

namespace Toyi\MjmlBuilder\Components;

class FontComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-font';
    }
}
