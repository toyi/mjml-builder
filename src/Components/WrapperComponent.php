<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Children\HasHeroComponent;
use Toyi\MjmlBuilder\Children\HasSectionComponent;

class WrapperComponent extends ComponentAbstract
{
    use HasSectionComponent;
    use HasHeroComponent;

    protected function tagName(): string
    {
        return 'mj-wrapper';
    }
}
