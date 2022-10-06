<?php

namespace Toyi\MjmlBuilder\Components;

class TitleComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-title';
    }
}
