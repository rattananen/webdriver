<?php

namespace Rattananen\Webdriver\Locator\Locators;

use Rattananen\Webdriver\Locator\LocatorInterface;
use Rattananen\Webdriver\Locator\LocatorTrait;

class TagName implements LocatorInterface
{
    use LocatorTrait;

    public function getUsing(): string
    {
        return 'tag name';
    }
}
