<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Children\HasColumnComponent;

class GroupComponent extends ComponentAbstract
{
    use HasColumnComponent;

    protected function tagName(): string
    {
        return 'mj-group';
    }
}
