<?php

namespace Rattananen\Webdriver\Tests;

use PHPUnit\Framework\TestCase;
use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\Tests\Utils\EndpointTestTrait;
use Rattananen\Webdriver\LocalEndInterface;

class ChromeEndpointTest extends TestCase
{
    use EndpointTestTrait;
    private LocalEndInterface $driver;
    public function setUp(): void
    {
        $this->driver = new GoogleChrome();
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

}
