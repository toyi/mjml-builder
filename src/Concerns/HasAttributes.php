<?php

namespace Toyi\MjmlBuilder\Concerns;

trait HasAttributes
{
    protected array $attributes = [];

    /**
     * The id represents the unique identifier of the component instance.
     *
     * @var string
     */
    protected string $id;

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            if (!is_int($key)) {
                continue;
            }

            $attributes[$value] = $value;
            unset($attributes[$key]);
        }

        $this->attributes = $attributes;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id = null): self
    {
        $this->id = $id ?: uniqid('', true);

        return $this;
    }
}
