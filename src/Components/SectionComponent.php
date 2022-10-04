<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Traits\HasChildren;
use Toyi\MjmlBuilder\Traits\HasTextComponent;

class SectionComponent extends ComponentAbstract
{
    use HasTextComponent;
    use HasChildren;

    protected function tagName(): string
    {
        return 'mj-section';
    }

    public function column(array $attributes = [], string $component_id = null): ColumnComponent
    {
        return new ColumnComponent($attributes, null, $this, $component_id);
    }
}
