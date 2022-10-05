<?php

namespace Toyi\MjmlBuilder\Components;

class TextComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;

    protected function tagName(): string
    {
        return 'mj-text';
    }
}
