<?php

namespace Toyi\MjmlBuilder\Tests\Feature;

use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Tests\TestCase;

class ContentTest extends TestCase
{
    public function testContentCanBeAString(): void
    {
        $text = new TextComponent([], 'Hello');

        $this->assertEquals('Hello', $text->getContent());
    }

    public function testContentCanBeAnArray(): void
    {
        $text = new TextComponent([], [
            'Hello',
            'World',
            'Foo',
            'Bar'
        ]);

        $this->assertEquals('Hello<br/>World<br/>Foo<br/>Bar', $text->getContent());
    }
}
