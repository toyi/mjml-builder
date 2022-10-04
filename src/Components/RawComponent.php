<?php

namespace Toyi\MjmlBuilder\Components;

class RawComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-raw';
    }

    protected function getContent(): ?string
    {
        return $this->content;
    }
}
