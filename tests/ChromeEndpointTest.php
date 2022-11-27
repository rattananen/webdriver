<?php

namespace Rattananen\Webdriver\Tests;

use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\Tests\Utils\EndpointTestAbstract;
use Rattananen\Webdriver\LocalEndInterface;

class ChromeEndpointTest extends EndpointTestAbstract
{
    private LocalEndInterface $driver;
    public function setUp(): void
    {
        $this->driver = new GoogleChrome('localhost:9515');
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

}
