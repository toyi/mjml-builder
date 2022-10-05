<?php

namespace Toyi\MjmlBuilder\Components;

class NavbarComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-navbar';
    }

    public function navbarLink(array $attributes = [], string $id = null): NavbarLinkComponent
    {
        return new NavbarLinkComponent($attributes, null, $this, $id);
    }
}
