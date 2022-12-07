<?php

namespace Rattananen\Webdriver\Locator;

abstract class LocatorAbstract implements LocatorInterface
{
    use LocatorTrait;

    public function __construct(public string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
