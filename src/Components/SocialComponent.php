<?php

namespace Toyi\MjmlBuilder\Components;

class SocialComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-social';
    }

    public function socialElement(array $attributes = [], string $id = null): SocialElementComponent
    {
        return new SocialElementComponent($attributes, null, $this, $id);
    }
}
