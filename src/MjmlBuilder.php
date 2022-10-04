<?php

namespace Toyi\MjmlBuilder;

use DeepCopy\DeepCopy;
use PrettyXml\Formatter;
use Toyi\MjmlBuilder\Components\BodyComponent;
use Toyi\MjmlBuilder\Components\HeadComponent;
use Toyi\MjmlBuilder\Components\MjmlComponent;

class MjmlBuilder
{
    protected MjmlComponent $root;

    protected HeadComponent $head;

    protected BodyComponent $body;

    public function __construct()
    {
        $this->root = new MjmlComponent();
        $this->head = (new HeadComponent())->setParent($this->root);
        $this->body = (new BodyComponent())->setParent($this->root);

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

    final public function root(): MjmlComponent
    {
        return $this->root;
    }

    final public function head(): HeadComponent
    {
        return $this->head;
    }

    final public function body(): BodyComponent
    {
        return $this->body;
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        return (new DeepCopy())->copy($this)->root->toMjmlArray();
    }

    public function toMjml(bool $pretty = false)
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

            return "<$tagName $attributes>$content</$tagName>";
        };

        $mjml = $tagToString($tree[0]);

        if ($pretty) {
            $mjml = e((new Formatter())->format($mjml));
        }

        return $mjml;
    }
}