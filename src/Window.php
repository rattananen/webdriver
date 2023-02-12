<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Rectangle;

class Window
{
    private string $basePath;

    public function __construct(
        private LocalEndInterface $driver,
        private string $sessionId
    ) {
        $this->basePath = 'session/' . $this->sessionId . '/window';
    }

    public function getRect(): Rectangle
    {
        $res = $this->driver->getClient()->get($this->basePath . '/rect');

        return Rectangle::fromArray(Helper::assertAndGetValue($res, 200));
    }

    public function setRect(Rectangle $rectangle): void
    {
        $res = $this->driver->getClient()->post($this->basePath . '/rect', ['body' => json_encode($rectangle)]);
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
