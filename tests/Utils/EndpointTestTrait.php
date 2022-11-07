<?php

namespace Rattananen\Webdriver\Tests\Utils;

use Rattananen\Webdriver\LocalEndInterface;

trait EndpointTestTrait
{
    abstract public function getDriver(): LocalEndInterface;
}
