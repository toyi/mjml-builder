<?php

namespace Toyi\MjmlBuilder\Concerns;

use Toyi\MjmlBuilder\Components\WrapperComponent;

trait HasWrapperComponent
{
    public function wrapper(array $attributes = [], string $component_id = null): WrapperComponent
    {
        return new WrapperComponent($attributes, null, $this, $component_id);
    }
}
