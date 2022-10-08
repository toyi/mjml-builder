<?php

namespace Toyi\MjmlBuilder\Tests\Feature;

use Toyi\MjmlBuilder\MjmlBuilder;
use Toyi\MjmlBuilder\Tests\TestCase;

class OutputTest extends TestCase
{
    protected MjmlBuilder $builder;

    public function testBuilderOutputsCorrectly()
    {
        $this->builder = new MjmlBuilder();
        $column = $this->builder->body()->wrapper()->section()->column();
        $column->text('First');
        $column->text('Second', ['color' => 'red']);
        $newColumn = $column->getParent()->column(['width' => '100%']);
        $newColumn->text('Third');

        $outputAsArray = [
            'tagName' => 'mjml',
            'children' => [
                [
                    'tagName' => 'mj-head',
                ],
                [
                    'tagName' => 'mj-body',
                    'children' => [
                        [
                            'tagName' => 'mj-wrapper',
                            'children' => [
                                [
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
                                                    'attributes' => [
                                                        'color' => 'red',
                                                    ],
                                                    'content' => 'Second',
                                                ],
                                            ],
                                        ],
                                        [
                                            'tagName' => 'mj-column',
                                            'attributes' => [
                                                'width' => '100%',
                                            ],
                                            'children' => [
                                                [
                                                    'tagName' => 'mj-text',
                                                    'content' => 'Third',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $outputAsMjml = [];
        $outputAsMjml[] = '<mjml>';
        $outputAsMjml[] = '<mj-head>';
        $outputAsMjml[] = '</mj-head>';
        $outputAsMjml[] = '<mj-body>';
        $outputAsMjml[] = '<mj-wrapper>';
        $outputAsMjml[] = '<mj-section>';
        $outputAsMjml[] = '<mj-column>';
        $outputAsMjml[] = '<mj-text>First</mj-text>';
        $outputAsMjml[] = '<mj-text color="red">Second</mj-text>';
        $outputAsMjml[] = '</mj-column>';
        $outputAsMjml[] = '<mj-column width="100%">';
        $outputAsMjml[] = '<mj-text>Third</mj-text>';
        $outputAsMjml[] = '</mj-column>';
        $outputAsMjml[] = '</mj-section>';
        $outputAsMjml[] = '</mj-wrapper>';
        $outputAsMjml[] = '</mj-body>';
        $outputAsMjml[] = '</mjml>';

        $this->assertEquals(implode('', $outputAsMjml), $this->builder->toMjml());
        $this->assertEquals($outputAsArray, $this->builder->toArray());
        $this->assertEquals(json_encode($outputAsArray), $this->builder->toJson());
    }
}
