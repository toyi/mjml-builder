<?php

namespace Toyi\MjmlBuilder\Concerns;

use Toyi\MjmlBuilder\Components\ButtonComponent;

trait HasButtonComponent
{
    public function button(array|string $content, string $href, array $attributes = [], string $component_id = null): ButtonComponent
    {
        return new ButtonComponent(array_merge(['href' => $href], $attributes), $content, $this, $component_id);
    }
}
