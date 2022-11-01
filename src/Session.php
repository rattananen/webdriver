<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\LocatorStrategy\LocatorStrategyInterface;
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

    public function findElement(LocatorStrategyInterface $ls): ?Element
    {
        $res = $this->driver->getClient()->post($this->basePath . '/element', ['body' => json_encode($ls)]);

        if ($res->getStatusCode() == 404) {
            return null;
        }

        $elem = Helper::decodeJsonResponse($res)['value'];

        return new Element($this->driver, $this->sessionId, current($elem));
    }

    /**
     * @return Element[]
     */
    public function findElements(LocatorStrategyInterface $ls): array
    {
        $res = $this->driver->getClient()->post($this->basePath . '/elements', ['body' => json_encode($ls)]);

        $data = Helper::decodeJsonResponse($res);
        $out = [];
        foreach ($data['value'] as $elem) {
            $out[] = new Element($this->driver, $this->sessionId, current($elem));
        }

        return $out;
    }

    public function execute(Script $sc): mixed
    {
        $res = $this->driver->getClient()->post($this->basePath . '/execute/sync', ['body' => json_encode($sc)]);
    }

    /**
     * @return string|SplFileObject return PNG in non-urlsafe base64 or SplFileObject if $filename set
     */
    public function screenshot(?string $filename = null): string|SplFileObject
    {
        $res = $this->driver->getClient()->get($this->basePath . '/screenshot');
        $data = Helper::decodeJsonResponse($res);

        if ($filename === null) {
            return $data['value'];
        }

        $file = new SplFileObject($filename, 'w');
        $file->fwrite(base64_decode($data['value']));
        return $file;
    }
}
