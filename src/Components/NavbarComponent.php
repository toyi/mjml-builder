<?php

namespace Toyi\MjmlBuilder\Components;

class NavbarComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-navbar';
    }

    public function navbarLink(string $content = null, string $href = null, array $attributes = [], string $id = null): NavbarLinkComponent
    {
        return new NavbarLinkComponent(array_merge($attributes, [
            'href' => $href,
        ]), $content, $this, $id);
    }
}
