<?php

namespace Toyi\MjmlBuilder\Children;

use Toyi\MjmlBuilder\Components\SectionComponent;

trait HasSectionComponent
{
    public function section(array $attributes = [], string $id = null): SectionComponent
    {
        return new SectionComponent($attributes, null, $this, $id);
    }
}
