<?php

namespace Toyi\MjmlBuilder\Components;

class NavbarLinkComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-navbar-link';
    }
}
