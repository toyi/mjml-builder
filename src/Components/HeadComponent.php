<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Utils\ArrayToCss;

class HeadComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-head';
    }

    public function title(string $content, string $id = null): TitleComponent
    {
        return new TitleComponent([], $content, $this, $id);
    }

    public function preview(string $content, string $id = null): PreviewComponent
    {
        return new PreviewComponent([], $content, $this, $id);
    }

    public function breakpoint(float $width, string $id = null): BreakpointComponent
    {
        return new BreakpointComponent(['width' => $width], null, $this, $id);
    }

    public function font(string $name, string $href, string $id = null): FontComponent
    {
        return new FontComponent(['name' => $name, 'href' => $href], null, $this, $id);
    }

    public function htmlAttributes(array $attributes = [], string $id = null): HtmlAttributesComponent
    {
        return new HtmlAttributesComponent($attributes, null, $this, $id);
    }

    public function attributes(array $attributes = [], string $id = null): AttributesComponent
    {
        return new AttributesComponent($attributes, null, $this, $id);
    }

    public function style(array $content, array $attributes = [], string $id = null): StyleComponent
    {
        return new StyleComponent($attributes, new ArrayToCss($content), $this, $id);
    }
}
