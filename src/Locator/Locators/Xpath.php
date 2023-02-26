<?php

namespace Rattananen\Webdriver\Locator\Locators;

use Rattananen\Webdriver\Locator\LocatorInterface;
use Rattananen\Webdriver\Locator\LocatorTrait;

class Xpath implements LocatorInterface
{
    use LocatorTrait;

    public function getUsing(): string
    {
        return 'xpath';
    }
}
