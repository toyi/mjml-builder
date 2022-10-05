<?php

namespace Toyi\MjmlBuilder\Components;

class HeroComponent extends ColumnComponent
{
    public function __construct(
        float $backgroundWidth,
        float $backgroundHeight,
        array $attributes = [],
        ?ComponentAbstract $parent = null,
        string $id = null)
    {
        $attributes['mode'] ??= 'fluid-height';

        if ($attributes['mode'] === 'fixed-height') {
            $attributes['height'] ??= "{$backgroundHeight}px";
        }

        parent::__construct(array_merge($attributes, [
            'background-width' => "{$backgroundWidth}px",
            'background-height' => "{$backgroundHeight}px",
        ]), null, $parent, $id);
    }

    protected function tagName(): string
    {
        return 'mj-hero';
    }
}
