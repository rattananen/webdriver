<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Rectangle;
use Rattananen\Webdriver\Types\WindowType;
use Rattananen\Webdriver\Entity\WindowInfo;

/**
 * window endpoints
 */
class Window
{
    private string $baseUri;

    public function __construct(
        private LocalEndInterface $driver,
        private string $sessionId
    ) {
        $this->baseUri = $this->driver->getBaseUri() . '/session/' . $this->sessionId . '/window';
    }

    public function getRect(): Rectangle
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/rect');

        return Rectangle::fromArray(Utils::getStatusOkValue($res));
    }

    public function setRect(Rectangle $rectangle): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/rect', $rectangle);
        Utils::assertStatusOk($res);
    }

    /**
     * shorthand for setRect()
     */
    public function rect(float $x, float $y, float $width, float $height): void
    {
        $this->setRect(new Rectangle($x, $y, $width, $height));
    }

    /**
     * @return string[]
     */
    public function getHandles(): array
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/handles');

        return Utils::getStatusOkValue($res);
    }

    public function getHandle(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri);

        return Utils::getStatusOkValue($res);
    }

    public function newWindow(WindowType $type = WindowType::window): WindowInfo
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/new', ['type' => $type]);

        return WindowInfo::fromArray(Utils::getStatusOkValue($res));
    }

    public function switchTo(string $handle): void
    {
        $res = $this->driver->getClient()->post($this->baseUri, ['handle' => $handle]);
        Utils::assertStatusOk($res);
    }

    /**
     * hide to `system tray`. 
     * does nothing in headless mode. 
     */
    public function minimize(): Rectangle
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/minimize');

        return Rectangle::fromArray(Utils::getStatusOkValue($res));
    }

    /**
     * does nothing in headless mode.
     */
    public function maximize(): Rectangle
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/maximize');

        return Rectangle::fromArray(Utils::getStatusOkValue($res));
    }

    /**
     * F11 fullscreen. 
     * does nothing in headless mode.
     */
    public function fullscreen(): Rectangle
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/fullscreen');

        return Rectangle::fromArray(Utils::getStatusOkValue($res));
    }
}
