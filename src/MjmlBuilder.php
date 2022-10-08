<?php

namespace Toyi\MjmlBuilder;

use DeepCopy\DeepCopy;
use Toyi\MjmlBuilder\Components\BodyComponent;
use Toyi\MjmlBuilder\Components\HeadComponent;
use Toyi\MjmlBuilder\Components\MjmlComponent;
use Toyi\MjmlBuilder\Utils\ArrayToInlineAttributes;

class MjmlBuilder
{
    protected MjmlComponent $mjml;

    protected HeadComponent $head;

    protected BodyComponent $body;

    public function __construct()
    {
        $this->mjml = new MjmlComponent();
        $this->head = (new HeadComponent())->setParent($this->mjml);
        $this->body = (new BodyComponent())->setParent($this->mjml);

        $this->configure();
    }

    protected function configureHead(HeadComponent $head): void
    {
        //
    }

    protected function configureBody(BodyComponent $body): void
    {
        //
    }

    protected function configure(): void
    {
        $this->configureHead($this->head());
        $this->configureBody($this->body());
    }

    public function mjml(): MjmlComponent
    {
        return $this->mjml;
    }

    public function head(): HeadComponent
    {
        return $this->head;
    }

    public function body(): BodyComponent
    {
        return $this->body;
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        return (new DeepCopy())->copy($this)->mjml()->toMjmlArray();
    }

    public function toMjml()
    {
        $tree = [$this->toArray()];

        $tagToString = function (array $tree) use (&$tagToString): string {
            $tagName = $tree['tagName'];
            $content = $tree['content'] ??= null;
            $children = $tree['children'] ?? [];

            if (count($children)) {
                foreach ($children as $child) {
                    $content .= $tagToString($child);
                }
            }

            $attributes = (new ArrayToInlineAttributes($tree['attributes'] ??= []));

            if (trim($attributes) !== '') {
                $attributes = " $attributes";
            }

            return "<$tagName$attributes>$content</$tagName>";
        };

        return $tagToString($tree[0]);
    }
}
