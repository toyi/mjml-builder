<?php

namespace Toyi\MjmlBuilder\Concerns;

use Toyi\MjmlBuilder\Components\SectionComponent;

trait HasSectionComponent
{
    public function section(array $attributes = [], string $component_id = null): SectionComponent
    {
        return new SectionComponent($attributes, null, $this, $component_id);
    }
}
