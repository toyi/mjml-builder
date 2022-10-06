<?php

namespace Toyi\MjmlBuilder\Components;

use Jawira\CaseConverter\Convert;

class AttributesComponent extends ComponentAbstract
{
    protected function tagName(): string
    {
        return 'mj-attributes';
    }

    public function all(array $attributes): self
    {
        return $this->apply('mj-all', $attributes);
    }

    public function class(string $name, array $attributes): self
    {
        $attributes['name'] = $name;

        return $this->apply('mj-class', $attributes);
    }

    public function apply(string $componentName, array $attributes = []): self
    {
        $componentName = (new Convert(str_replace('mj-', '', $componentName)))->toPascal();
        $class_e = explode('\\', $this::class);
        $basename = array_pop($class_e);
        $component = str_replace($basename, $componentName, static::class).'Component';

        new $component($attributes, null, $this);

        return $this;
    }
}
