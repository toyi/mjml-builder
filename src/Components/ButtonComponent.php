<?php

namespace Toyi\MjmlBuilder\Components;

class ButtonComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;

    protected function tagName(): string
    {
        return 'mj-button';
    }
}
