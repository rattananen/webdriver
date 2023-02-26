<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Rattananen\Webdriver\LocalEndInterface;

trait WindowTestTrait
{
    abstract public function getDriver(): LocalEndInterface;

    abstract public static function assertEquals($expected, $actual, string $message = ''): void;

    public function testRect(): void
    {
        $session = $this->getDriver()->newSession();

        $session->window->rect(1, 2, 1024, 768);

        $rect = $session->window->getRect();

        static::assertEquals(1, $rect->x);
        static::assertEquals(2, $rect->y);
        static::assertEquals(1024, $rect->width);
        static::assertEquals(768, $rect->height);
    }
}