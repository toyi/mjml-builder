<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Contracts\EndingTagContract;

class RawComponent extends ComponentAbstract implements EndingTagContract
{
    protected function getContent(): ?string
    {
        return $this->content;
    }
}
