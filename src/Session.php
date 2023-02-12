<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Script;
use Rattananen\Webdriver\Entity\PrintProperties;

class Session
{
    use FindElementTrait, ScreenshotTrait;

    private string $basePath;

    public readonly Window $window;

    public function __construct(
        private LocalEndInterface $driver,
        public readonly string $sessionId
    ) {
        $this->basePath = 'session/' . $this->sessionId;

        $this->window = new Window($this->driver, $this->sessionId);
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

    public function __destruct()
    {
        $this->delete();
    }

    public function delete(): void
    {
        //deleteAsync doesn't work in destructor. it might be PHP is terminate before deleteAsync done.
        $this->driver->getClient()->delete($this->basePath);
    }

    public function getCurrentUrl(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/url');

        return Helper::assertAndGetValue($res, 200);
    }

    public function navigateTo(string $url): void
    {
        $res = $this->driver->getClient()->post($this->basePath . '/url', ['body' => json_encode(['url' => $url])]);

        Helper::assertStatusCode($res, 200);
    }


    public function execute(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->basePath . '/execute/sync', ['body' => json_encode($script)]);

        return Helper::assertAndGetValue($res, 200);
    }

    /**
     * shorthand for execute()
     */
    public function js(string $script, array $args = []): mixed
    {
        return $this->execute(new Script($script, $args));
    }

    /**
     * it's promise like. The last argument work same as resolve callback in promise
     */
    public function executeAsync(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->basePath . '/execute/async', ['body' => json_encode($script)]);

        return Helper::assertAndGetValue($res, 200);
    }

    /**
     * shorthand for executeAsync()
     */
    public function jsAsync(string $script, array $args = []): mixed
    {
        return $this->executeAsync(new Script($script, $args));
    }

    public function print(?PrintProperties $printProperties = null): string
    {
        $res = $this->driver->getClient()->post($this->basePath . '/print', ['body' => json_encode($printProperties ?? new PrintProperties())]);

        return Helper::assertAndGetValue($res, 200);
    }

    public function printTo(string $filename, ?PrintProperties $printProperties = null): \SplFileObject
    {
        $bin = base64_decode($this->print($printProperties));

        $file = new \SplFileObject($filename, 'w');
        $file->fwrite($bin);
        return $file;
    }

    /**
     * @return string page source normalized by browser
    */
    public function getPageSource(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/source');

        return Helper::assertAndGetValue($res, 200);
    }
}
