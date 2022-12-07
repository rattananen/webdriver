<?php

namespace Rattananen\Webdriver\Locator;

class TagName extends LocatorAbstract
{
    public function getUsing(): string
    {
        return 'tag name';
    }
}
