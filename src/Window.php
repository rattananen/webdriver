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

        return Rectangle::fromArray(Helper::decodeJsonResponse($res)['value']);
    }

    public function setRect(Rectangle $rectangle): void
    {
        $this->driver->getClient()->post($this->basePath . '/rect', ['body' => json_encode($rectangle)]);
    }

    /**
     * shorthand for setRect()
    */
    public function rect(float $x, float $y, float $width, float $height): void
    {
        $this->setRect(new Rectangle($x, $y, $width, $height));
    }
}
