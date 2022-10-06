<?php

namespace Toyi\MjmlBuilder\Components;

class AccordionTextComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;

    protected bool $canHaveChildren = false;

    protected function tagName(): string
    {
        return 'mj-accordion-text';
    }
}
