<?php

namespace Toyi\MjmlBuilder\Tests\Unit;

use Toyi\MjmlBuilder\Components\ColumnComponent;
use Toyi\MjmlBuilder\Components\ComponentAbstract;
use Toyi\MjmlBuilder\Components\SectionComponent;
use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Tests\TestCase;

class ComponentTreeTest extends TestCase
{
    public function testChildCanBeFoundById(): void
    {
        $section = new SectionComponent();

        $section->column()->chain(function (ColumnComponent $column) {
            $column->text('First', [], 'id1');
            $column->text('Second', [], 'id2');
            $column->text('Third', [], 'id3');
        });

        $child = $section->findChildById('id2');

        $this->assertEquals('id2', $child->getId());
        $this->assertEquals('Second', $child->getContent());
    }

    public function testParentCanBeUnset(): void
    {
        $parent = new ColumnComponent();
        $child = $parent->text();

        $this->assertEquals($child->getParent(), $parent);

        $parent->removeChild($child);

        $this->assertNull($child->getParent());

        $this->assertEquals([
            'tagName' => 'mj-column',
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
                    'tagName' => 'mj-text',
                ],
            ],
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
                    'content' => $prepended->getContent(),
                ],
                [
                    'tagName' => 'mj-text',
                    'content' => $middleChild->getContent(),
                ],
                [
                    'tagName' => 'mj-text',
                    'content' => $appended->getContent(),
                ],
            ],
        ], $parent->toMjmlArray());
    }

    private function pushChildProvider(): array
    {
        return [
            [
                TextComponent::class,
            ],
            [
                new TextComponent(),
            ],
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
                    'tagName' => 'mj-text',
                ],
            ],
        ], $parent->toMjmlArray());
    }

    public function testMethodCanBeChainedOnAComponent(): void
    {
        $section = new SectionComponent();
        $section->chain(function (SectionComponent $section) {
            $section->column()->chain(function (ColumnComponent $column) {
                $column->text('First');
                $column->text('Second');
            });
            $section->column()->chain(function (ColumnComponent $column) {
                $column->text('Third');
            });
        });

        $this->assertEquals([
            'tagName' => 'mj-section',
            'children' => [
                [
                    'tagName' => 'mj-column',
                    'children' => [
                        [
                            'tagName' => 'mj-text',
                            'content' => 'First',
                        ],
                        [
                            'tagName' => 'mj-text',
                            'content' => 'Second',
                        ],
                    ],
                ],
                [
                    'tagName' => 'mj-column',
                    'children' => [
                        [
                            'tagName' => 'mj-text',
                            'content' => 'Third',
                        ],
                    ],
                ],
            ],
        ], $section->toMjmlArray());
    }
}
