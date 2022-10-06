<?php

namespace Toyi\MjmlBuilder\Components;

class SpacerComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-spacer';
    }
}
