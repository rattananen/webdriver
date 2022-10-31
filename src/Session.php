<?php

namespace Jkk\Webdriver;

use SplFileObject;

/** @todo implement missing command , add handle errors, maybe create SessionInterface */
class Session
{
    private string $basePath;

    public readonly Window $window;

    public function __construct(
        private DriverInterface $driver,
        private string $sessionId
    ) {
        $this->basePath = 'session/' . $this->sessionId;

        $this->window = new Window($this->driver, $this->sessionId);
    }

    public function __destruct()
    {
        $this->delete();
    }

    public function delete(): void
    {
        /** for some reason deleteAsync doesn't work in destructor */
        $this->driver->getClient()->delete($this->basePath);
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
     * @return ?string return PNG in non-urlsafe base64 or null if $file set (for performance)
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
