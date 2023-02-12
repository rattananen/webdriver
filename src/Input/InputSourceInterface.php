<?php

namespace Rattananen\Webdriver\Input;


interface InputSourceInterface extends \JsonSerializable
{
    public function getType():string;

    public function getId():string;
}
