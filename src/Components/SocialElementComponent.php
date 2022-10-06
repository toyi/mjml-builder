<?php

namespace Toyi\MjmlBuilder\Components;

class SocialElementComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-social-element';
    }
}
