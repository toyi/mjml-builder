<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Traits\HasSectionComponent;

class WrapperComponent extends ComponentAbstract
{
    use HasSectionComponent;

    protected function tagName(): string
    {
        return 'mj-wrapper';
    }
}
