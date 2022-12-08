<?php

namespace Rattananen\Webdriver\Locator\Locators;

use Rattananen\Webdriver\Locator\LocatorAbstract;

class CssSelector extends LocatorAbstract
{
    public function getUsing(): string
    {
        return 'css selector';
    }
}
