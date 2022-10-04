<?php

namespace Toyi\MjmlBuilder;

class ArrayToInlineAttributes
{
    protected array $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function __toString(): string
    {
        $attributes = [];

        foreach ($this->attributes as $key => $value) {
            if (is_array($value)) {
                $styles = $value;
                $value = "";
                foreach ($styles as $k => $v) {
                    $value .= "$k:$v;";
                }
            }

            $attributes[$key] = $key . '="' . $value . '"';
        }

        return implode(' ', $attributes);
    }
}
