<?php

namespace Toyi\MjmlBuilder\Components;

class ImageComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-image';
    }
}
