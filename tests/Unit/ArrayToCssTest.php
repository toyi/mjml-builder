<?php namespace Toyi\MjmlBuilder\Tests\Unit;

use Toyi\MjmlBuilder\ArrayToCss;
use Toyi\MjmlBuilder\Tests\TestCase;

class ArrayToCssTest extends TestCase
{
    public function testArrayAreConvertedToCss(): void
    {
        $array = [
            '#uniqueid' => [
                'background' => 'yellow'
            ],
            '.class' => [
                'font-size' => '10px',
                'display' => 'none'
            ]
        ];

        $expected = '#uniqueid{background:yellow;} .class{font-size:10px;display:none;}';

        $this->assertEquals($expected, (new ArrayToCss($array)));
    }
}
