<?php

namespace Rattananen\Webdriver\LocatorStrategy;

trait LocatorStrategyTrait
{
    public function jsonSerialize(): mixed
    {
        return [
            'using' => $this->getUsing(),
            'value' => $this->getValue(),
        ];
    }
}