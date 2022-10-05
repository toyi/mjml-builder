<?php

namespace Toyi\MjmlBuilder\Children;

use Toyi\MjmlBuilder\Components\HeroComponent;

trait HasHeroComponent
{
    public function hero(string $backgroundWidth, string $backgroundHeight, array $attributes = [], string $id = null): HeroComponent
    {
        return new HeroComponent($backgroundWidth, $backgroundHeight, $attributes, $this, $id);
    }
}
