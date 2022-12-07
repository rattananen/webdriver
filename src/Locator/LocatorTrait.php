<?php

namespace Rattananen\Webdriver\Locator;

trait LocatorTrait
{
    public function jsonSerialize(): mixed
    {
        return [
            'using' => $this->getUsing(),
            'value' => $this->getValue(),
        ];
    }
}