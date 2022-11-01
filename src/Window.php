<?php

namespace Rattananen\Webdriver;

class Window
{
    private string $basePath;

    public function __construct(
        private DriverInterface $driver,
        private string $sessionId
    ) {
        $this->basePath = 'session/' . $this->sessionId . '/window';
    }

    public function getRect(): Rectangle
    {
        $res = $this->driver->getClient()->get($this->basePath . '/rect');
        $data = Helper::decodeJsonResponse($res);
        return Rectangle::fromArray($data['value']);
    }

    public function setRect(Rectangle $rect): void
    {
        $this->driver->getClient()->post($this->basePath . '/rect', ['body' => json_encode($rect)]);
    }
}
