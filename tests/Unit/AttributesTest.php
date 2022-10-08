<?php

namespace Toyi\MjmlBuilder\Tests\Unit;

use Toyi\MjmlBuilder\Components\ColumnComponent;
use Toyi\MjmlBuilder\Tests\TestCase;

class AttributesTest extends TestCase
{
    public function testAttributesCanBeAddedToComponents(): void
    {
        $column = new ColumnComponent();
        $column->setAttributes(['width' => '100%']);

        $this->assertEquals([
            'tagName' => 'mj-column',
            'attributes' => [
                'width' => '100%'
            ]
        ], $column->toMjmlArray());
    }

    public function testAttributesCanBeSetupWithoutValue(): void
    {
        $column = new ColumnComponent();
        $column->setAttributes(['full-width']);

        $this->assertEquals([
            'tagName' => 'mj-column',
            'attributes' => [
                'full-width' => 'full-width'
            ]
        ], $column->toMjmlArray());
    }
}
