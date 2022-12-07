<?php

namespace Rattananen\Webdriver\Locator;

interface LocatorInterface extends \JsonSerializable
{
    public function getUsing(): string;

    public function getValue(): string;
}
