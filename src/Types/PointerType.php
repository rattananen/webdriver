<?php

namespace Rattananen\Webdriver\Types;

enum PointerType: string
{
    case mouse = 'mouse';

    case touch = 'touch';

    case pen = 'pen';
}
