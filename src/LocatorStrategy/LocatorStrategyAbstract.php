<?php

namespace Jkk\Webdriver\LocatorStrategy;

abstract class LocatorStrategyAbstract implements LocatorStrategyInterface
{
    use LocatorStrategyTrait;

    public function __construct(public string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
