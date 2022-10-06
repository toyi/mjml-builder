<?php

namespace Toyi\MjmlBuilder\Tests\Feature;

use Toyi\MjmlBuilder\Components\ColumnComponent;
use Toyi\MjmlBuilder\Components\ComponentAbstract;
use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Tests\TestCase;

class ComponentTreeTest extends TestCase
{
    public function testParentCanBeUnset(): void
    {
        $parent = new ColumnComponent();
        $child = $parent->text();

        $this->assertEquals($child->getParent(), $parent);

        $parent->removeChild($child);

        $this->assertNull($child->getParent());

        $this->assertEquals([
            'tagName' => 'mj-column'
        ], $parent->toMjmlArray());
    }

    public function testParentCanHaveChildren(): void
    {
        $parent = new ColumnComponent();
        $child = new TextComponent();

        $this->assertNull($child->getParent());
        $this->assertCount(0, $parent->getChildren());

        $parent->push($child);

        $this->assertEquals($child->getParent(), $parent);
        $this->assertCount(1, $parent->getChildren());

        $this->assertEquals([
            'tagName' => 'mj-column',
            'children' => [
                [
                    'tagName' => 'mj-text'
                ]
            ]
        ], $parent->toMjmlArray());
    }

    public function testChildrenCanBeAppendedAndPrependedToParents(): void
    {
        $parent = new ColumnComponent();
        $appended = new TextComponent([], 'appended');
        $prepended = new TextComponent([], 'prepended');

        $this->assertNull($appended->getParent());
        $this->assertCount(0, $parent->getChildren());
        $this->assertCount(0, $parent->getAppendedChild());
        $this->assertCount(0, $parent->getPrependedChild());

        $parent->appendChild($appended);
        $parent->prependChild($prepended);
        $middleChild = $parent->text('inserted between $prepended and $appended');

        $this->assertEquals($appended->getParent(), $parent);
        $this->assertEquals($prepended->getParent(), $parent);
        $this->assertCount(1, $parent->getChildren());
        $this->assertCount(1, $parent->getAppendedChild());
        $this->assertCount(1, $parent->getPrependedChild());

        $this->assertEquals([
            'tagName' => 'mj-column',
            'children' => [
                [
                    'tagName' => 'mj-text',
                    'content' => $prepended->getContent()
                ],
                [
                    'tagName' => 'mj-text',
                    'content' => $middleChild->getContent()
                ],
                [
                    'tagName' => 'mj-text',
                    'content' => $appended->getContent()
                ],
            ]
        ], $parent->toMjmlArray());
    }

    private function pushChildProvider(): array
    {
        return [
            [
                TextComponent::class,
            ],
            [
                new TextComponent()
            ]
        ];
    }

    /**
     * @dataProvider pushChildProvider
     */
    public function testChildCanBePushedToParent(string|ComponentAbstract $childToPush): void
    {
        $parent = new ColumnComponent();
        $child = $parent->push($childToPush);

        $children = $parent->getChildren();
        $this->assertCount(1, $children);
        $this->assertEquals(TextComponent::class, $child::class);

        $this->assertEquals([
            'tagName' => 'mj-column',
            'children' => [
                [
                    'tagName' => 'mj-text'
                ]
            ]
        ], $parent->toMjmlArray());
    }
}
