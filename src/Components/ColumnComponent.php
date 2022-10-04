<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Traits\HasButtonComponent;
use Toyi\MjmlBuilder\Traits\HasChildren;
use Toyi\MjmlBuilder\Traits\HasImageComponent;
use Toyi\MjmlBuilder\Traits\HasTextComponent;

class ColumnComponent extends ComponentAbstract
{
    use HasTextComponent;
    use HasButtonComponent;
    use HasImageComponent;
    use HasChildren;

    protected function tagName(): string
    {
        return 'mj-column';
    }

    public function table(array $attributes = []): TableComponent
    {
        return new TableComponent($attributes, null, $this);
    }
}
