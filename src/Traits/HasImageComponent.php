<?php

namespace Toyi\MjmlBuilder\Traits;

use Exception;
use Toyi\MjmlBuilder\Components\ImageComponent;

trait HasImageComponent
{
    /**
     * @throws Exception
     */
    public function image(array $attributes = [], string $component_id = null): ImageComponent
    {
        if (! array_key_exists('src', $attributes)) {
            throw new Exception('ImageComponent must have an src attribute');
        }

        return new ImageComponent($attributes, null, $this, $component_id);
    }
}
