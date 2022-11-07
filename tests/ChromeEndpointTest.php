<?php

namespace Rattananen\Webdriver\Tests;

use PHPUnit\Framework\TestCase;
use Rattananen\Webdriver\Tests\Utils\EndpointTestTrait;

class ChromeEndpointTest extends TestCase
{
   // use EndpointTestTrait;

    public function testLazy():void
    {
        $this->assertEquals('lazy', 'yes');
    }
}