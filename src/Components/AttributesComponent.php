<?php

namespace Toyi\MjmlBuilder\Components;

use Illuminate\Support\Str;

class AttributesComponent extends ComponentAbstract
{
    public function all(array $attributes): self
    {
        return $this->apply('mj-all', $attributes);
    }

    public function class(string $name, array $attributes): self
    {
        $attributes['name'] = $name;

        return $this->apply('mj-class', $attributes);
    }

    public function apply(string $component_name, array $attributes = []): self
    {
        $basename = Str::of($component_name)->replaceFirst('mj-', '')->studly()->toString();
        $component = Str::of(static::class)->replace(
            Str::of(static::class)->classBasename(),
            $basename.'Component'
        )->toString();

        /**
         * @var ComponentAbstract $component
         */
        new $component($attributes, null, $this);

        return $this;
    }
}
