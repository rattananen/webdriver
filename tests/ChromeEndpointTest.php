<?php

namespace Rattananen\Webdriver\Tests;

use PHPUnit\Framework\TestCase;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\RemoteEnds\ChromeDriver;
use Rattananen\Webdriver\LocalEnds\GoogleChrome;

use Rattananen\Webdriver\Tests\Traits\EnvironmentTrait;
use Rattananen\Webdriver\Tests\Traits\LocalEndTestTrait;
use Rattananen\Webdriver\Tests\Traits\WindowTestTrait;
use Rattananen\Webdriver\Tests\Traits\SessionTestTrait;
use Rattananen\Webdriver\Tests\Traits\ElementTestTrait;

class ChromeEndpointTest extends TestCase
{
    use EnvironmentTrait,
        LocalEndTestTrait,
        WindowTestTrait,
        SessionTestTrait,
        ElementTestTrait;

    private LocalEndInterface $local;

    private ChromeDriver $remote;

    public function setUp(): void
    {
        $this->remote = new ChromeDriver();
        $this->remote->start();
        $this->local = new GoogleChrome();
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->local;
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMinimizeState(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->minimize();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMaximizeState(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->maximize();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testFullscreenState(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->fullscreen();
    }
}
