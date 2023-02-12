<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Rectangle;

class Element
{
    use ScreenshotTrait, FindElementTrait;

    private string $basePath;

    public function __construct(
        private LocalEndInterface $driver,
        public readonly string $sessionId,
        public readonly string $elementId
    ) {
        $this->basePath = 'session/' . $this->sessionId . '/element/' . $this->elementId;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

    public function getText(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/text');

        return Helper::assertAndGetValue($res,  200);
    }

    public function getTagName(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/name');

        return Helper::assertAndGetValue($res,  200);
    }

    public function getRect(): Rectangle
    {
        $res = $this->driver->getClient()->get($this->basePath . '/rect');

        return Rectangle::fromArray(Helper::assertAndGetValue($res, 200));
    }

    public function getAttribute(string $name): ?string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/attribute/' . $name);

        return Helper::assertAndGetValue($res, 200);
    }

    public function getProperty(string $name): ?string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/property/' . $name);

        return Helper::assertAndGetValue($res, 200);
    }

    /**
     * @return string css value computed by browser.
    */
    public function getCssValue(string $prop): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/css/' . $prop);

        return Helper::assertAndGetValue($res, 200);
    }

    public function click(): void
    {
        $res = $this->driver->getClient()->post($this->basePath . '/click', ['body' => '{}']);
        Helper::assertStatusCode($res, 200);
    }

    public function clear(): void
    {
        $res = $this->driver->getClient()->post($this->basePath . '/clear', ['body' => '{}']);

        Helper::assertStatusCode($res, 200);
    }

    public function sendKeys(string $keys): void
    {
        $res = $this->driver->getClient()->post($this->basePath . '/value', ['body' => json_encode(['text' => $keys])]);

        Helper::assertStatusCode($res, 200);
    }

}
