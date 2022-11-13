<?php

namespace Rattananen\Webdriver\Entity;

interface DriverStatusInterface
{
    public function getMessage():string;

    public function getReady():bool;
}