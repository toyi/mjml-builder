<?php

namespace Toyi\MjmlBuilder\Utils;

class ArrayToCss
{
    protected array $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    public function __toString(): string
    {
        $res = [];

        foreach ($this->input as $selector => $attributes) {
            $attrs = [];

            foreach ($attributes as $key => $value) {
                $attrs[] = "$key:$value;";
            }

            $res[] = $selector.'{'.implode('', $attrs).'}';
        }

        return implode(' ', $res);
    }
}
