<?php

namespace Toyi\MjmlBuilder\Components;

class RawComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;

    protected function getContent(): ?string
    {
        return $this->content;
    }
}
