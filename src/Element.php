<?php

namespace Rattananen\Webdriver;

class Element
{
    use ScreenshotTrait, FindElementTrait;

    private string $basePath;

    public function __construct(
        private LocalEndInterface $driver,
        private string $sessionId,
        private string $elementId
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

    public function text(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/text');

        Helper::assertStatusCode($res, 200);

        return Helper::decodeJsonResponse($res)['value'];
    }

}
