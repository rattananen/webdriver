<?php

namespace Rattananen\Webdriver\Locator;

class CssSelector extends LocatorAbstract
{
    public function getUsing(): string
    {
        return 'css selector';
    }
}
