<?php

namespace Toyi\MjmlBuilder\Components;

class TextComponent extends ComponentAbstract
{
    protected bool $isPlain = true;

    protected function tagName(): string
    {
        return 'mj-text';
    }
}
