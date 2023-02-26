<?php

namespace Rattananen\Webdriver\Tests;

use PHPUnit\Framework\TestCase;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\LocalEnds\GoogleChrome;

use Rattananen\Webdriver\Tests\Traits\TestEnviromentTrait;
use Rattananen\Webdriver\Tests\Traits\LocalEndTestTrait;
use Rattananen\Webdriver\Tests\Traits\WindowTestTrait;
use Rattananen\Webdriver\Tests\Traits\SessionTestTrait;
use Rattananen\Webdriver\Tests\Traits\ElementTestTrait;

class ChromeEndpointTest extends TestCase
{
    use TestEnviromentTrait,
        LocalEndTestTrait,
        WindowTestTrait,
        SessionTestTrait,
        ElementTestTrait;

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
