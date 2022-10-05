<?php

namespace Toyi\MjmlBuilder\Concerns;

use Toyi\MjmlBuilder\Components\TextComponent;

trait HasTextComponent
{
    public function text(array|string $content = '', array $attributes = [], string $component_id = null): TextComponent
    {
        return new TextComponent($attributes, $content, $this, $component_id);
    }
}
