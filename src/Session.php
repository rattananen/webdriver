<?php

namespace Jkk\Webdriver;

use SplFileObject;

/** @todo add handle errors*/
class Session
{

    private string $basePath;

    public function __construct(
        private DriverInterface $driver,
        private string $sessionId
    ) {
        $this->basePath = 'session/' . $this->sessionId;
    }

    public function getCurrentUrl(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/url');
        return Helper::decodeJsonResponse($res)['value'];
    }

    public function navigateTo(string $url): void
    {
        $this->driver->getClient()->post($this->basePath . '/url', ['body' => json_encode(['url' => $url])]);
    }

    /**
     * @return ?string return PNG in non-urlsafe base64 or null if $file set
     */
    public function screenshot(?SplFileObject $file = null): ?string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/screenshot');
        $data = Helper::decodeJsonResponse($res);
        if ($file === null) {
            return $data['value'];
        }
        $file->fwrite(base64_decode($data['value']));
        return null;
    }
}
