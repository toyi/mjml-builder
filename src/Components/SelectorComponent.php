<?php

namespace Toyi\MjmlBuilder\Components;

class SelectorComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-selector';
    }

    public function htmlAttribute(string $value, string $id = null): HtmlAttributeComponent
    {
        return new HtmlAttributeComponent([], $value, $this, $id);
    }
}
