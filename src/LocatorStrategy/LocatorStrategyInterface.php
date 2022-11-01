<?php

namespace Jkk\Webdriver\LocatorStrategy;

interface LocatorStrategyInterface extends \JsonSerializable
{
    public function getUsing(): string;

    public function getValue(): string;
}
