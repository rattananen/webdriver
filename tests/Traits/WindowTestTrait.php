<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Entity\WindowInfo;


trait WindowTestTrait
{
    abstract public function getDriver(): LocalEndInterface;

    abstract public static function assertNotEmpty($actual, string $message = ''): void;
    abstract public static function assertEquals($expected, $actual, string $message = ''): void;
    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;
    abstract public static function assertContains($needle, iterable $haystack, string $message = ''): void;
    abstract public static function assertNotContains($needle, iterable $haystack, string $message = ''): void;

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

    public function testWindowHandle(): void
    {
        $session = $this->getDriver()->newSession();

        $handle = $session->window->getHandle();

        static::assertNotEmpty($handle);

        $info =  $session->window->newWindow();

        static::assertInstanceOf(WindowInfo::class, $info);

        $handles = $session->window->getHandles();

        static::assertContains($handle, $handles);
        static::assertContains($info->handle, $handles);

        $session->window->switchTo($info->handle);

        static::assertEquals($info->handle, $session->window->getHandle());

        static::assertNotContains($info->handle, $session->window->close());
    }
}
