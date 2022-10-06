<?php

namespace Toyi\MjmlBuilder\Components;

class PreviewComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-preview';
    }
}
