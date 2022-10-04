<?php

namespace Toyi\MjmlBuilder\Traits;

use Toyi\MjmlBuilder\Components\WrapperComponent;

trait HasWrapperComponent
{
    public function wrapper(array $attributes = [], string $component_id = null): WrapperComponent
    {
        return new WrapperComponent($attributes, null, $this, $component_id);
    }
}
