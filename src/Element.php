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

        return Utils::getStatusOkValue($res);
    }

    public function getTagName(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/name');

        return Utils::getStatusOkValue($res);
    }

    public function getRect(): Rectangle
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/rect');

        return Rectangle::fromArray(Utils::getStatusOkValue($res));
    }

    public function getAttribute(string $name): ?string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/attribute/' . $name);

        return Utils::getStatusOkValue($res);
    }

    public function getProperty(string $name): ?string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/property/' . $name);

        return Utils::getStatusOkValue($res);
    }

    /**
     * @return string css value computed by browser.
     */
    public function getCssValue(string $prop): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/css/' . $prop);

        return Utils::getStatusOkValue($res);
    }

    public function click(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/click');
        Utils::assertStatusOK($res);
    }

    public function clear(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/clear');
        Utils::assertStatusOK($res);
    }

    public function sendKeys(string $keys): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/value', ['text' => $keys]);
        Utils::assertStatusOK($res);
    }

    public function isEnabled(): bool
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/enabled');

        return Utils::getStatusOkValue($res);
    }

    /**
     * @return bool checked preperty
     */
    public function isSelected(): bool
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/selected');

        return Utils::getStatusOkValue($res);
    }

    public function getComputedRole(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/computedrole');
        return Utils::getStatusOkValue($res);
    }

    public function getComputedLabel(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/computedlabel');
        return Utils::getStatusOkValue($res);
    }

    /**
     * shadow root must accessible by javascript (mode=open) to get result
    */
    public function getShadowRoot(): ?ShadowRoot
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/shadow');
        if ($res->getStatusCode() == 404) {
            return null;
        }
        $value =  Utils::getStatusOkValue($res);
        return new ShadowRoot($this->driver, $this->sessionId, $value[W3C::SHADOW_ROOT_IDENTIFIER]);
    }

    public function jsonSerialize(): mixed
    {
        return [W3C::ELEMENT_IDENTIFIER => $this->elementId];
    }
}
