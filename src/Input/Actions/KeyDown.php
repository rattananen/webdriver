<?php

namespace Rattananen\Webdriver\Input\Actions;

use Rattananen\Webdriver\Input\ActionInterface;
use Rattananen\Webdriver\Input\Actions\Traits\KeyTrait;

class KeyDown implements ActionInterface
{
    use KeyTrait;

    public function getType(): string
    {
        return 'keyDown';
    }
}
