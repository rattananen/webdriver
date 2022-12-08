<?php

namespace Rattananen\Webdriver\Locator\Locators;

use Rattananen\Webdriver\Locator\LocatorAbstract;

class TagName extends LocatorAbstract
{
    public function getUsing(): string
    {
        return 'tag name';
    }
}
