<?php

namespace Rattananen\Webdriver\Locator;

class Xpath extends LocatorAbstract
{
    public function getUsing(): string
    {
        return 'xpath';
    }
}
