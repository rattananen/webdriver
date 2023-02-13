<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Rectangle;

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

        return Rectangle::fromArray(Helper::assertAndGetValue($res, 200));
    }

    public function setRect(Rectangle $rectangle): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/rect', $rectangle);
        Helper::assertStatusCode($res, 200);
    }

    /**
     * shorthand for setRect()
     */
    public function rect(float $x, float $y, float $width, float $height): void
    {
        $this->setRect(new Rectangle($x, $y, $width, $height));
    }
}
