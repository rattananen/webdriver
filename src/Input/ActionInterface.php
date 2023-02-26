<?php

namespace Rattananen\Webdriver\Input;

interface ActionInterface  extends \JsonSerializable
{
    public function getType(): string;
}
