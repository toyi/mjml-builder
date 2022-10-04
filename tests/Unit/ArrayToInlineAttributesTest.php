<?php namespace Toyi\MjmlBuilder\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Toyi\MjmlBuilder\ArrayToInlineAttributes;

class ArrayToInlineAttributesTest extends TestCase
{
    public function testArrayAreConvertedToInlineAttributes(): void
    {
        $array = [
            'color' => 'red',
            'padding' => '25px 20px',
            'styles' => [
                'background' => 'yellow',
                'font-size' => '10px',
                'display' => 'none'
            ]
        ];

        $expected = 'color="red" padding="25px 20px" styles="background:yellow;font-size:10px;display:none;"';

        $this->assertEquals($expected, (new ArrayToInlineAttributes($array)));
    }
}
