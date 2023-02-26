<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Script;
use Rattananen\Webdriver\Entity\PrintProperties;
use Rattananen\Webdriver\Input\InputSourceInterface;

class Session
{
    use FindElementTrait, ScreenshotTrait;

    private string $baseUri;

    private bool $deleted = false;

    public readonly Window $window;

    public function __construct(
        private LocalEndInterface $driver,
        public readonly string $sessionId
    ) {
        $this->baseUri = $this->driver->getBaseUri() . '/session/' . $this->sessionId;

        $this->window = new Window($this->driver, $this->sessionId);
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

    public function __destruct()
    {
        if (!$this->deleted) {
            $this->delete();
        }
    }

    public function delete(): void
    {
        $this->driver->getClient()->delete($this->baseUri);
        $this->deleted = true;
    }

    public function getCurrentUrl(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/url');

        return Helper::assertAndGetValue($res, 200);
    }

    public function navigateTo(string $url): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/url', ['url' => $url]);

        Helper::assertStatusCode($res, 200);
    }


    public function execute(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/execute/sync', $script);

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
        $res = $this->driver->getClient()->post($this->baseUri . '/execute/async', $script);

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
        $res = $this->driver->getClient()->post($this->baseUri . '/print', ['body' => json_encode($printProperties ?? new PrintProperties())]);

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
        $res = $this->driver->getClient()->get($this->baseUri . '/source');

        return Helper::assertAndGetValue($res, 200);
    }

    public function performActions(InputSourceInterface ...$inputs): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/actions', ['actions' => $inputs]);

        Helper::assertAndGetValue($res, 200);
    }

    public function releaseActions(): void
    {
        $res = $this->driver->getClient()->delete($this->baseUri . '/actions');

        Helper::assertAndGetValue($res, 200);
    }
}
