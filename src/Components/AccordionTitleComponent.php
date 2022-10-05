<?php

namespace Toyi\MjmlBuilder\Components;

class AccordionTitleComponent extends ComponentAbstract
{
    protected bool $isEndingTag = true;

    protected function tagName(): string
    {
        return 'mj-accordion-title';
    }
}
