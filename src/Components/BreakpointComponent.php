<?php

namespace Toyi\MjmlBuilder\Components;

class BreakpointComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-breakpoint';
    }
}
