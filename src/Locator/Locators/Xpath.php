<?php

namespace Rattananen\Webdriver\Locator\Locators;

use Rattananen\Webdriver\Locator\LocatorAbstract;

class Xpath extends LocatorAbstract
{
    public function getUsing(): string
    {
        return 'xpath';
    }
}
