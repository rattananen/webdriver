<?php

namespace Rattananen\Webdriver\Locator;

trait LocatorTrait
{

    public function __construct(public string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'using' => $this->getUsing(),
            'value' => $this->getValue(),
        ];
    }
}
