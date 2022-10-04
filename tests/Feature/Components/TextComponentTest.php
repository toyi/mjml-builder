<?php namespace Toyi\MjmlBuilder\Tests\Feature\Components;

use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Tests\TestCase;

class TextComponentTest extends TestCase
{
    protected TextComponent $text;

    protected function setUp(): void
    {
        parent::setUp();

        $this->text = new TextComponent();
    }

    public function testTextComponentMjmlArray(): void
    {

    }
}
