<?php

namespace Rattananen\Webdriver\Types;

enum PageLoadStrategy: string
{
    case none = 'none';
    case eager = 'eager';
    case normal = 'normal';
}
