<?php

namespace Rattananen\Webdriver\LocatorStrategy;

class CssSelector extends LocatorStrategyAbstract
{
    public function getUsing():string
    {
        return 'css selector';
    }
}