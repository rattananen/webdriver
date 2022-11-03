<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Script;
use Rattananen\Webdriver\Entity\PrintProperties;
use SplFileObject;

class Session
{
    use FindElementTrait, ScreenshotTrait;

    private string $basePath;

    public readonly Window $window;

    public function __construct(
        private LocalEndInterface $driver,
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
        //for some reason deleteAsync doesn't work in destructor
        $this->driver->getClient()->delete($this->basePath);
    }

    public function getCurrentUrl(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/url');

        Helper::assertStatusCode($res, [200]);

        return Helper::decodeJsonResponse($res)['value'];
    }

    public function navigateTo(string $url): void
    {
        $res = $this->driver->getClient()->post($this->basePath . '/url', ['body' => json_encode(['url' => $url])]);

        Helper::assertStatusCode($res, [200]);
    }


    public function execute(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->basePath . '/execute/sync', ['body' => json_encode($script)]);

        Helper::assertStatusCode($res, [200]);

        return Helper::decodeJsonResponse($res)['value'];
    }

    /**
     * it's promise like. The last argument work same as resolve callback in promise
     */
    public function executeAsync(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->basePath . '/execute/async', ['body' => json_encode($script)]);

        Helper::assertStatusCode($res, [200]);

        return Helper::decodeJsonResponse($res)['value'];
    }

    public function print(?PrintProperties $printProperties = null, ?string $filename = null): string|SplFileObject|false
    {
        $res = $this->driver->getClient()->post($this->basePath . '/print', ['body' => json_encode($printProperties ?? new PrintProperties())]);

        if ($res->getStatusCode() >= 400) {
            return false;
        }

        $data = Helper::decodeJsonResponse($res);

        if ($filename === null) {
            return $data['value'];
        }

        $file = new SplFileObject($filename, 'w');
        $file->fwrite(base64_decode($data['value']));
        return $file;
    }
}
