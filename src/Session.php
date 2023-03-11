<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Entity\Script;
use Rattananen\Webdriver\Entity\Cookie;
use Rattananen\Webdriver\Entity\PrintProperties;
use Rattananen\Webdriver\Entity\TimeoutsConfiguration;
use Rattananen\Webdriver\Input\InputSourceInterface;
use Rattananen\Webdriver\Types\W3C;

class Session
{
    use FindElementTrait, ScreenshotTrait;

    private string $baseUri;

    private bool $deleted = false;

    /**
     * window endpoints
     */
    public readonly Window $window;

    public function __construct(private LocalEndInterface $driver, public readonly string $sessionId)
    {
        $this->baseUri = $this->driver->getBaseUri() . '/session/' . $this->sessionId;

        $this->window = new Window($this->driver, $this->sessionId);
    }

    /**
     * @internal
     */
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

        return Utils::getStatusOkValue($res);
    }

    public function navigateTo(string $url): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/url', ['url' => $url]);

        Utils::assertStatusOk($res);
    }

    /**
     * @see https://www.w3.org/TR/webdriver/#dfn-timeouts-configuration
     */
    public function setTimeouts(TimeoutsConfiguration $timeouts): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/timeouts', $timeouts);

        Utils::assertStatusOk($res);
    }

    /**
     * shorthand for setTimeouts()
     */
    public function timeouts(?int $script = 5000, int $pageLoad = 7000, int $implicit = 4000): void
    {
        $this->setTimeouts(new TimeoutsConfiguration($script, $pageLoad, $implicit));
    }

    public function getTimeouts(): TimeoutsConfiguration
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/timeouts');

        return TimeoutsConfiguration::fromArray(Utils::getStatusOkValue($res));
    }

    public function back(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/back');
        Utils::assertStatusOk($res);
    }

    public function forward(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/forward');
        Utils::assertStatusOk($res);
    }

    public function refresh(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/refresh');
        Utils::assertStatusOk($res);
    }

    public function getTitle(): string
    {
        $res = $this->driver->getClient()->get($this->baseUri . '/title');
        return Utils::getStatusOkValue($res);
    }

    /**
     * Execute javascript
     * 
     * @see https://github.com/jlipps/simple-wd-spec#execute-script
     */
    public function execute(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/execute/sync', $script);

        return Utils::getStatusOkValue($res);
    }

    /**
     * shorthand for execute()
     */
    public function js(string $script, array $args = []): mixed
    {
        return $this->execute(new Script($script, $args));
    }

    /**
     * Promise-like execution. The last argument is resolver callback in promise
     */
    public function executeAsync(Script $script): mixed
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/execute/async', $script);

        return Utils::getStatusOkValue($res);
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

        return Utils::getStatusOkValue($res);
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

        return Utils::getStatusOkValue($res);
    }

    public function performActions(InputSourceInterface ...$inputs): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/actions', ['actions' => $inputs]);

        Utils::assertStatusOk($res);
    }

    public function releaseActions(): void
    {
        $res = $this->driver->getClient()->delete($this->baseUri . '/actions');

        Utils::assertStatusOk($res);
    }

    public function switchToFrame(Element|int|null $id): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/frame', ['id' => $id]);

        Utils::assertStatusOk($res);
    }

    public function switchToParentFrame(): void
    {
        $res = $this->driver->getClient()->post($this->baseUri . '/frame/parent');

        Utils::assertStatusOk($res);
    }

    public function getActiveElement(): ?Element
    {
        $res = $this->getDriver()->getClient()->get($this->getBaseUri() . '/element/active');
        if ($res->getStatusCode() == 404) {
            return null;
        }

        $value = Utils::getStatusOkValue($res);

        return new Element($this->driver, $this->sessionId, $value[W3C::ELEMENT_IDENTIFIER]);
    }

    /**
     * @return Cookie[]
     */
    public function getCookies(): array
    {
        $res = $this->getDriver()->getClient()->get($this->getBaseUri() . '/cookie');

        $out = [];
        foreach (Utils::getStatusOkValue($res) as $item) {
            $out[] = Cookie::fromArray($item);
        }

        return $out;
    }

    public function getCookie(string $name): ?Cookie
    {
        $res = $this->getDriver()->getClient()->get($this->getBaseUri() . '/cookie/' . $name);

        if ($res->getStatusCode() == 404) {
            return null;
        }

        return Cookie::fromArray(Utils::getStatusOkValue($res));
    }

    public function addCookie(Cookie $cookie): void
    {
        $res = $this->getDriver()->getClient()->post($this->getBaseUri() . '/cookie', ['cookie' => $cookie]);
        Utils::assertStatusOk($res);
    }

    public function deleteCookie(string $name): void
    {
        $res = $this->getDriver()->getClient()->delete($this->getBaseUri() . '/cookie/' . $name);
        Utils::assertStatusOk($res);
    }

    public function deleteCookies(): void
    {
        $res = $this->getDriver()->getClient()->delete($this->getBaseUri() . '/cookie');
        Utils::assertStatusOk($res);
    }

    public function dismissAlert(): void
    {
        $res = $this->getDriver()->getClient()->post($this->getBaseUri() . '/alert/dismiss');
        Utils::assertStatusOk($res);
    }

    public function acceptAlert(): void
    {
        $res = $this->getDriver()->getClient()->post($this->getBaseUri() . '/alert/accept');
        Utils::assertStatusOk($res);
    }

    public function getAlertText(): ?string
    {
        $res = $this->getDriver()->getClient()->get($this->getBaseUri() . '/alert/text');
        return Utils::getStatusOkValue($res);
    }

    public function sendAlertText(string $text): void
    {
        $res = $this->getDriver()->getClient()->post($this->getBaseUri() . '/alert/text', ['text' => $text]);
        Utils::assertStatusOk($res);
    }
}
