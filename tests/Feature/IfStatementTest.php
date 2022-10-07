<?php

namespace Toyi\MjmlBuilder\Tests\Feature;

use Closure;
use Toyi\MjmlBuilder\Components\ColumnComponent;
use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Statements\If\IfStatement;
use Toyi\MjmlBuilder\Tests\TestCase;

class IfStatementTest extends TestCase
{
    private function testIfStatementAppendsMjRawToComponentProvider(): array
    {
        return [
            [
                function (): ColumnComponent {
                    $column = new ColumnComponent();
                    IfStatement::make('true', 'This is true!')->else('This is false!')->generate($column);
                    return $column;
                }
            ],
            [
                function (): ColumnComponent {
                    return (new ColumnComponent())->if(IfStatement::make('true', 'This is true!')->else('This is false!'));
                }
            ]
        ];
    }

    /**
     * @dataProvider testIfStatementAppendsMjRawToComponentProvider
     * @param Closure $makeColumn
     * @return void
     */
    public function testIfStatementAppendsMjRawToComponent(Closure $makeColumn): void
    {
        $children = $makeColumn()->getChildren();

        $childAContent = [
            "<!-- htmlmin:ignore -->",
            "<?php if(true){ ?>",
            "<!-- htmlmin:ignore -->&nbsp;",
        ];
        $childAContent = implode("\n", $childAContent);

        $childBContent = "This is true!";

        $childCContent = [
            "<!-- htmlmin:ignore -->",
            "<?php }else{ ?>",
            "<!-- htmlmin:ignore -->&nbsp;",
        ];
        $childCContent = implode("\n", $childCContent);

        $childDContent = "This is false!";

        $childEContent = [
            "<!-- htmlmin:ignore -->",
            "<?php } ?>",
            "<!-- htmlmin:ignore -->&nbsp;"
        ];
        $childEContent = implode("\n", $childEContent);

        $this->assertCount(5, $children);
        $this->assertEquals($childAContent, $children[0]->getContent());
        $this->assertEquals($childBContent, $children[1]->getContent());
        $this->assertEquals($childCContent, $children[2]->getContent());
        $this->assertEquals($childDContent, $children[3]->getContent());
        $this->assertEquals($childEContent, $children[4]->getContent());
    }

    public function testIfStatementGenerateAValidStatement(): void
    {
        $expected = [
            '<!-- htmlmin:ignore -->',
            '<?php if(true){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;This is true!<!-- htmlmin:ignore -->',
            '<?php }else{ ?>',
            '<!-- htmlmin:ignore -->&nbsp;This is false!<!-- htmlmin:ignore -->',
            '<?php } ?>',
            '<!-- htmlmin:ignore -->&nbsp;'
        ];

        $if = IfStatement::make('true', 'This is true!')->else('This is false!');
        $this->assertEquals(implode("\n", $expected), $if->generate());
    }

    public function testIfStatementGenerateAValidInlineStatement(): void
    {
        $expected = [
            "\n<?php if(true){ ?>",
            'This is true!',
            '<?php }else{ ?>',
            'This is false!',
            "<?php } ?>\n"
        ];

        $expected = implode("\n", $expected);

        $if = IfStatement::make('true', 'This is true!')->else('This is false!');

        $this->assertEquals($expected, (clone $if)->inline()->generate());
        $this->assertEquals($expected, (clone $if)->generate(new TextComponent()));
        $this->assertEquals($expected, (new TextComponent())->if($if)->getContent());
    }

    public function testIfStatementCanHaveMultipleElseIfs(): void
    {
        $expected = [
            '<!-- htmlmin:ignore -->',
            '<?php if(1 === 3){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;This is true!<!-- htmlmin:ignore -->',
            '<?php }else if(1 === 4){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;ElseIfA<!-- htmlmin:ignore -->',
            '<?php }else if(1 === 5){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;ElseIfB<!-- htmlmin:ignore -->',
            '<?php }else{ ?>',
            '<!-- htmlmin:ignore -->&nbsp;This is false!<!-- htmlmin:ignore -->',
            '<?php } ?>',
            '<!-- htmlmin:ignore -->&nbsp;'
        ];

        $if = IfStatement::make('1 === 3', 'This is true!')
            ->elseIf('1 === 4', 'ElseIfA')
            ->elseIf('1 === 5', 'ElseIfB')
            ->else('This is false!')
            ->generate();

        $this->assertEquals(implode("\n", $expected), $if);
    }
}
