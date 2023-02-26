<?php

namespace Rattananen\Webdriver\Input\Actions;

use Rattananen\Webdriver\Input\ActionInterface;

class PointerCancel implements ActionInterface
{
    public function getType(): string
    {
        return 'pointerCancel';
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => $this->getType()
        ];
    }
}
