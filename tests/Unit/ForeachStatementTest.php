<?php

namespace Toyi\MjmlBuilder\Tests\Unit;

use Toyi\MjmlBuilder\Components\ColumnComponent;
use Toyi\MjmlBuilder\Components\TextComponent;
use Toyi\MjmlBuilder\Statements\ForeachStatement;
use Toyi\MjmlBuilder\Tests\TestCase;

class ForeachStatementTest extends TestCase
{
    public function testForeachStatementAppendsMjRawToComponent(): void
    {
        $column = new ColumnComponent();
        $column->foreach(ForeachStatement::make('[1,2,3]', function (ColumnComponent $column) {
            $column->text('<?php echo $value ?> : <?php echo $key ?><br/>');
        }));

        $children = $column->getChildren();

        $childAContent = [
            '<!-- htmlmin:ignore -->',
            '<?php foreach([1,2,3] as $key => $value){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;',
        ];
        $childAContent = implode("\n", $childAContent);

        $childBContent = '<?php echo $value ?> : <?php echo $key ?><br/>';

        $childCContent = [
            '<!-- htmlmin:ignore -->',
            '<?php } ?>',
            '<!-- htmlmin:ignore -->&nbsp;',
        ];
        $childCContent = implode("\n", $childCContent);

        $this->assertCount(3, $children);
        $this->assertEquals($childAContent, $children[0]->getContent());
        $this->assertEquals($childBContent, $children[1]->getContent());
        $this->assertEquals($childCContent, $children[2]->getContent());
    }

    public function testForeachStatementCanHaveAnEmptyCallback(): void
    {
        $expected = [
            '<!-- htmlmin:ignore -->',
            '<?php if(count([1,2,3]) === 0){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;Empty<!-- htmlmin:ignore -->',
            '<?php }else{ ?>',
            '<!-- htmlmin:ignore -->&nbsp;<!-- htmlmin:ignore -->',
            '<?php foreach([1,2,3] as $key => $value){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;<?php echo $value ?> : <?php echo $key ?><br/><!-- htmlmin:ignore -->',
            '<?php } ?>',
            '<!-- htmlmin:ignore -->&nbsp;<!-- htmlmin:ignore -->',
            '<?php } ?>',
            '<!-- htmlmin:ignore -->&nbsp;',
        ];

        $foreach = ForeachStatement::make('[1,2,3]', '<?php echo $value ?> : <?php echo $key ?><br/>')->empty(fn () => 'Empty')->generate();

        $this->assertEquals(implode("\n", $expected), $foreach);
    }

    public function testForeachStatementGenerateAValidStatement(): void
    {
        $expected = [
            '<!-- htmlmin:ignore -->',
            '<?php foreach([1,2,3] as $key => $value){ ?>',
            '<!-- htmlmin:ignore -->&nbsp;<?php echo $value ?> : <?php echo $key ?><br/><!-- htmlmin:ignore -->',
            '<?php } ?>',
            '<!-- htmlmin:ignore -->&nbsp;',
        ];

        $foreach = ForeachStatement::make('[1,2,3]', '<?php echo $value ?> : <?php echo $key ?><br/>')->generate();
        $this->assertEquals(implode("\n", $expected), $foreach);
    }

    public function testForeachStatementGenerateAValidInlineStatement(): void
    {
        $expected = [
            "\n".'<?php foreach([1,2,3] as $key => $value){ ?>',
            '<?php echo $value ?> : <?php echo $key ?><br/>',
            "<?php } ?>\n",
        ];

        $expected = implode("\n", $expected);

        $foreach = ForeachStatement::make('[1,2,3]', '<?php echo $value ?> : <?php echo $key ?><br/>');

        $this->assertEquals($expected, (clone $foreach)->inline()->generate());
        $this->assertEquals($expected, (clone $foreach)->generate(new TextComponent()));
        $this->assertEquals($expected, (new TextComponent())->foreach($foreach)->getContent());
    }
}
