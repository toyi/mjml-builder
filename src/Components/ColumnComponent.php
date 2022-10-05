<?php

namespace Toyi\MjmlBuilder\Components;

use Exception;

class ColumnComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-column';
    }

    public function table(array $attributes = []): TableComponent
    {
        return new TableComponent($attributes, null, $this);
    }

    /**
     * @throws Exception
     */
    public function image(array $attributes = [], string $id = null): ImageComponent
    {
        if (! array_key_exists('src', $attributes)) {
            throw new Exception('ImageComponent must have an src attribute');
        }

        return new ImageComponent($attributes, null, $this, $id);
    }

    public function text(array|string $content = '', array $attributes = [], string $id = null): TextComponent
    {
        return new TextComponent($attributes, $content, $this, $id);
    }

    public function carousel(array $attributes = [], string $id = null): CarouselComponent
    {
        return new CarouselComponent($attributes, null, $this, $id);
    }

    public function social(array $attributes = [], string $id = null): SocialComponent
    {
        return new SocialComponent($attributes, null, $this, $id);
    }

    public function navbar(array $attributes = [], string $id = null): NavbarComponent
    {
        return new NavbarComponent($attributes, null, $this, $id);
    }

    public function spacer(float $height, string $id = null): SpacerComponent
    {
        return new SpacerComponent(['height' => "{$height}px"], null, $this, $id);
    }

    public function divider(float $height, string $id = null): DividerComponent
    {
        return new DividerComponent(['height' => "{$height}px"], null, $this, $id);
    }

    public function button(array|string $content, string $href, array $attributes = [], string $id = null): ButtonComponent
    {
        return new ButtonComponent(array_merge(['href' => $href], $attributes), $content, $this, $id);
    }
}
