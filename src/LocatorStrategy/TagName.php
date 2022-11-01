<?php

namespace Rattananen\Webdriver\LocatorStrategy;

class TagName extends LocatorStrategyAbstract
{
    public function getUsing(): string
    {
        return 'tag name';
    }
}
