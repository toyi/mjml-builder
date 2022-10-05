<?php

namespace Toyi\MjmlBuilder\Children;

use Toyi\MjmlBuilder\Components\ColumnComponent;

trait HasColumnComponent
{
    public function column(array $attributes = [], string $id = null): ColumnComponent
    {
        return new ColumnComponent($attributes, null, $this, $id);
    }
}
