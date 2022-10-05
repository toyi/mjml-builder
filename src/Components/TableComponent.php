<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Utils\ArrayToInlineAttributes;

class TableComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;

    protected bool $alreadyHasARow = false;

    protected function normalizeCell(array|string $cell): array
    {
        if (is_string($cell)) {
            $cell = [
                'attributes' => [],
                'content' => $cell,
            ];
        }

        return $cell;
    }

    public function row(array $cells, array $attributes = []): self
    {
        $row = [
            'attributes' => $attributes,
            'cells' => $cells,
        ];

        $cell_tag = $this->alreadyHasARow ? 'td' : 'th';

        $row['cells'] = array_map(function (array|string $cell) use ($cell_tag) {
            $cell = $this->normalizeCell($cell);

            return "<$cell_tag ".(new ArrayToInlineAttributes($cell['attributes'])).'>'.$cell['content']."</$cell_tag>";
        }, $row['cells']);

        $this->alreadyHasARow = true;

        $this->content .= '<tr '.(new ArrayToInlineAttributes($row['attributes'])).'>'.implode('', $row['cells']).'</tr>';

        return $this;
    }
}
