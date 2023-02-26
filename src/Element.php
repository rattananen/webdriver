<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Rectangle;
use Rattananen\Webdriver\Types\W3C;

class Element implements \JsonSerializable
{
    use ScreenshotTrait, FindElementTrait;

    private string $baseUri;

    public function __construct(
        private LocalEndInterface $driver,
        public readonly string $sessionId,
        public readonly string $elementId
    ) {
        $this->baseUri = $this->driver->getBaseUri() . '/session/' . $this->sessionId . '/element/' . $this->elementId;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

    public function getText(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/text');

        return Helper::assertAndGetValue($res,  200);
    }

    public function getTagName(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/name');

        return Helper::assertAndGetValue($res,  200);
    }

    public function getRect(): Rectangle
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/rect');

        return Rectangle::fromArray(Helper::assertAndGetValue($res, 200));
    }

    public function getAttribute(string $name): ?string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/attribute/' . $name);

        return Helper::assertAndGetValue($res, 200);
    }

    public function getProperty(string $name): ?string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/property/' . $name);

        return Helper::assertAndGetValue($res, 200);
    }

    /**
     * @return string css value computed by browser.
     */
    public function getCssValue(string $prop): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/css/' . $prop);
        
        return Helper::assertAndGetValue($res, 200);
    }

    public function click(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/click');
        Helper::assertStatusCode($res, 200);
    }

    public function clear(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/clear');
        Helper::assertStatusCode($res, 200);
    }

    public function sendKeys(string $keys): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/value', ['text' => $keys]);
        Helper::assertStatusCode($res, 200);
    }


    public function jsonSerialize(): mixed
    {
        return [W3C::ELEMENT_IDENTIFIER => $this->elementId];
    }
}
