<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Traits\HasChildren;
use Toyi\MjmlBuilder\Traits\HasSectionComponent;
use Toyi\MjmlBuilder\Traits\HasWrapperComponent;

class BodyComponent extends ComponentAbstract
{
    use HasWrapperComponent;
    use HasSectionComponent;
    use HasChildren;

    protected function tagName(): string
    {
        return 'mj-body';
    }
}
