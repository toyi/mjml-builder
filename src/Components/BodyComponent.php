<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Children\HasHeroComponent;
use Toyi\MjmlBuilder\Children\HasSectionComponent;

class BodyComponent extends ComponentAbstract
{
    use HasSectionComponent;
    use HasHeroComponent;

    protected function tagName(): string
    {
        return 'mj-body';
    }

    public function wrapper(array $attributes = [], string $id = null): WrapperComponent
    {
        return new WrapperComponent($attributes, null, $this, $id);
    }
}
