<?php

namespace Toyi\MjmlBuilder\Components;

class CarouselImageComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-carousel-image';
    }
}
