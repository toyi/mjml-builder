<?php

namespace Toyi\MjmlBuilder\Components;

use Toyi\MjmlBuilder\Concerns\HasSectionComponent;
use Toyi\MjmlBuilder\Concerns\HasWrapperComponent;

class BodyComponent extends ComponentAbstract
{
    use HasWrapperComponent;
    use HasSectionComponent;
}
