<?php

namespace Jkk\Webdriver\LocatorStrategy;

class Xpath extends LocatorStrategyAbstract
{
    public function getUsing(): string
    {
        return 'xpath';
    }
}
