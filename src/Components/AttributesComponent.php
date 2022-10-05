<?php

namespace Toyi\MjmlBuilder\Components;

use Illuminate\Support\Str;
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
        $basename = class_basename($this);
        $component = str_replace($basename, $componentName, static::class).'Component';

        /**
         * @var ComponentAbstract $component
         */
        new $component($attributes, null, $this);

        return $this;
    }
}
