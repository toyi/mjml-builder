<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Concerns\HasChildren;
use Toyi\MjmlBuilder\Concerns\HasTextComponent;

class SectionComponent extends ComponentAbstract
{
    use HasTextComponent;
    use HasChildren;

    public function column(array $attributes = [], string $component_id = null): ColumnComponent
    {
        return new ColumnComponent($attributes, null, $this, $component_id);
    }
}
