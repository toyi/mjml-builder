<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Concerns\HasButtonComponent;
use Toyi\MjmlBuilder\Concerns\HasImageComponent;
use Toyi\MjmlBuilder\Concerns\HasTextComponent;

class ColumnComponent extends ComponentAbstract
{
    use HasTextComponent;
    use HasButtonComponent;
    use HasImageComponent;

    public function table(array $attributes = []): TableComponent
    {
        return new TableComponent($attributes, null, $this);
    }
}
