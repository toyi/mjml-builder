<?php

namespace Toyi\MjmlBuilder\Components;

class HtmlAttributeComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-html-attribute';
    }
}
