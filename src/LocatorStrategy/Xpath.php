<?php

namespace Rattananen\Webdriver\LocatorStrategy;

class Xpath extends LocatorStrategyAbstract
{
    public function getUsing(): string
    {
        return 'xpath';
    }
}
