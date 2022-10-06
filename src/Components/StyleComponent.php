<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Utils\ArrayToCss;

class StyleComponent extends ComponentAbstract
{
    protected bool $canHaveChildren = false;

    public function __construct(array $attributes = [], ArrayToCss $content = null, ?ComponentAbstract $parent = null, string $id = null)
    {
        parent::__construct($attributes, (string) $content, $parent, $id);
    }

    protected function tagName(): string
    {
        return 'mj-style';
    }
}
