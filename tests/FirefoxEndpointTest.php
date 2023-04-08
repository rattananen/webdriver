<?php

namespace Rattananen\Webdriver\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\RemoteEnds\GeckoDriver;
use Rattananen\Webdriver\LocalEnds\Firefox;
use Rattananen\Webdriver\ShadowRoot;

use Rattananen\Webdriver\Tests\Traits\EnvironmentTrait;
use Rattananen\Webdriver\Tests\Traits\LocalEndTestTrait;
use Rattananen\Webdriver\Tests\Traits\WindowTestTrait;
use Rattananen\Webdriver\Tests\Traits\SessionTestTrait;
use Rattananen\Webdriver\Tests\Traits\ElementTestTrait;

class FirefoxEndpointTest extends TestCase
{
    use EnvironmentTrait,
        LocalEndTestTrait,
        WindowTestTrait,
        SessionTestTrait,
        ElementTestTrait 
        {
        setUpBeforeClass as _setUpBeforeClass;
    }

    public static LocalEndInterface $local;

    public static GeckoDriver $remote;

    public static function setUpBeforeClass(): void
    {
        self::_setUpBeforeClass();

        // static::$remote = new GeckoDriver();
        // static::$remote->start();

        static::$local = new Firefox();
    }

    public function getDriver(): LocalEndInterface
    {
        return static::$local;
    }


    #[DoesNotPerformAssertions]
    public function testMinimizeState(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->minimize();
    }

    #[DoesNotPerformAssertions]
    public function testMaximizeState(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->maximize();
    }

    #[DoesNotPerformAssertions]
    public function testFullscreenState(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->fullscreen();

    }

    #[DoesNotPerformAssertions]
    public function testAccessibilityEndpoint(): void
    {
        //firefox does not implement accessibility endpoints yet
    }

    public function testShadowElement(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/shadow.html';

        $session->navigateTo($url);

        $elem = $session->find('date-info');

        $root = $elem->getShadowRoot();

        static::assertInstanceOf(ShadowRoot::class, $root);

        //firefox does not implement find element for shadow dom yet
        //static::assertEquals('1995',  $root->find('.year')?->getText());
    }
}
