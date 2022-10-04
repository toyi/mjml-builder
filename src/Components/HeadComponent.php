<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\ArrayToCss;

class HeadComponent extends ComponentAbstract
{
    public function title(array|string $content, array $attributes = [], string $component_id = null): TitleComponent
    {
        return new TitleComponent($attributes, $content, $this, $component_id);
    }

    public function preview(array|string $content, array $attributes = [], string $component_id = null): PreviewComponent
    {
        return new PreviewComponent($attributes, $content, $this, $component_id);
    }

    public function attributes(array $attributes = [], string $component_id = null): AttributesComponent
    {
        return new AttributesComponent($attributes, null, $this, $component_id);
    }

    public function style(array $content, array $attributes = [], string $component_id = null): StyleComponent
    {
        return new StyleComponent($attributes, new ArrayToCss($content), $this, $component_id);
    }

    protected function tagName(): string
    {
        return 'mj-head';
    }
}
