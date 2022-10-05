<?php

namespace Toyi\MjmlBuilder\Components;

class HtmlAttributesComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-html-attributes';
    }

    public function selector(string $path, string $id = null): SelectorComponent
    {
        return new SelectorComponent(['path' => $path], null, $this, $id);
    }
}
