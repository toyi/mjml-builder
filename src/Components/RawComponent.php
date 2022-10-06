<?php

namespace Toyi\MjmlBuilder\Components;

class RawComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-raw';
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
