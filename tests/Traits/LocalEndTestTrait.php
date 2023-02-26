<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Session;
use Rattananen\Webdriver\Entity\DriverStatusInterface;

trait LocalEndTestTrait
{
    abstract public function getDriver(): LocalEndInterface;

    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;

    public function testNewSession(): void
    {
        $session = $this->getDriver()->newSession();

        static::assertInstanceOf(Session::class, $session);
    }

    public function testStatus(): void
    {
        $status = $this->getDriver()->status();

        static::assertInstanceOf(DriverStatusInterface::class, $status);
    }
}
