<?php

namespace Toyi\MjmlBuilder\Tests\Unit;

use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Tests\TestCase;

class ContentTest extends TestCase
{
    public function testAStringCanBePushedToAStringContent(): void
    {
        $text = new TextComponent([], 'Hello');
        $text->pushContent(' World');
        $this->assertEquals('Hello World', $text->getContent());
    }

    public function testAStringCanBePushedToAnArrayContent(): void
    {
        $text = new TextComponent([], ['Hello', 'World']);
        $text->pushContent('Foobar');
        $this->assertEquals('Hello<br />World<br />Foobar', $text->getContent());
    }

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
            'Bar',
        ]);

        $this->assertEquals('Hello<br />World<br />Foo<br />Bar', $text->getContent());
    }
}
