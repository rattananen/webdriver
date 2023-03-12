<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\Input\InputSources\Wheel;
use Rattananen\Webdriver\Input\InputSources\Pointer;
use Rattananen\Webdriver\Input\InputSources\Key;
use Rattananen\Webdriver\Types\CodePoint;
use Rattananen\Webdriver\Types\CookieSameSite;
use Rattananen\Webdriver\Entity\Cookie;

trait SessionTestTrait
{
    abstract public function getDriver(): LocalEndInterface;

    abstract public static function getWebBaseUri(): string;

    abstract public static function getBaseTmpDir(): string;

    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;

    abstract public static function assertNotEmpty($actual, string $message = ''): void;

    abstract public static function assertGreaterThan($expected, $actual, string $message = ''): void;

    abstract public static function assertEquals($expected, $actual, string $message = ''): void;

    abstract public static function assertCount(int $expectedCount, $haystack, string $message = ''): void;

    abstract public static function assertNull($actual, string $message = ''): void;
    /**
     * @doesNotPerformAssertions
     */
    public function testDelete(): void
    {
        $session = $this->getDriver()->newSession();

        $session->delete();
    }

    public function testNavigate(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/img.html';
        $session->navigateTo($url);

        $result = $session->getCurrentUrl();

        static::assertEquals($url, $result);
    }

    public function testSimpleJavascript(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/js.html';
        $session->navigateTo($url);

        $result = $session->js('const [a, b] = arguments;return a+b;', [4, 6]);

        static::assertEquals(10, $result);

        $result = $session->jsAsync('const [a, b, c, d, resolve] = arguments;resolve(window.TestJs.sum(a, b, c, d));', [1, 2, 3, 4]);

        static::assertEquals(10, $result);
    }

    public function testFindSlowElement(): void
    {
        $session = $this->getDriver()->newSession();

        $session->timeouts(implicit:1000);
        $url = static::getWebBaseUri() . '/js.html';

        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        static::assertInstanceOf(Element::class, $elem);
    }

    public function testFindElements(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $elements = $session->findAll('.common-img');

        static::assertInstanceOf(Element::class, $elements[0]);
    }

    public function testGetPageSource(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        static::assertNotEmpty($session->getPageSource());
    }

    public function testTimeouts(): void
    {
        $session = $this->getDriver()->newSession();

        $session->timeouts(100, 200, 300);

        $timeouts = $session->getTimeouts();

        static::assertEquals(100, $timeouts->script);
        static::assertEquals(200, $timeouts->pageLoad);
        static::assertEquals(300, $timeouts->implicit);
    }

    public function testHistory(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $url1 = static::getWebBaseUri() . '/img.html';

        $session->navigateTo($url1);

        $session->back();

        static::assertEquals($url, $session->getCurrentUrl());

        $session->forward();

        static::assertEquals($url1, $session->getCurrentUrl());

        $session->refresh();
    }

    public function testGetTitle(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        static::assertEquals('common page', $session->getTitle());
    }

    public function testHoldCtrlAndClickThenRelease(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/input.html';

        $session->navigateTo($url);

        $keyBoard = new Key();
        $keyBoard
            ->pause() //wait for move
            ->keyPress(CodePoint::Control);

        $btn = $session->find('#btn-test1');
        $mouse = new Pointer();
        $mouse
            ->move(70, 0, $btn)
            ->click();

        $session->performActions($keyBoard, $mouse);

        $textKeyDown = $session->find('#text-kdown');
        $textKeyUp = $session->find('#text-kup');
        $textMouseDown = $session->find('#text-mousedown');
        $textMouseUp = $session->find('#text-mouseup');
        $textMouseMove = $session->find('#text-mousemove');

        static::assertEquals('Control', $textKeyDown->getProperty('value'));
        static::assertEquals('Control', $textKeyUp->getProperty('value'));
        static::assertEquals('B0x130y25ctrltrue', $textMouseDown->getProperty('value'));
        static::assertEquals('B0x130y25', $textMouseUp->getProperty('value'));
        static::assertEquals('x130y25', $textMouseMove->getProperty('value'));

        $btn2 = $session->find('#btn-test2');

        static::assertEquals('clicked', $btn2->getText());

        $session->releaseActions();
    }

    public function testWheel(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/input.html';

        $session->navigateTo($url);

        $text = $session->find('#text-long');

        $wheel = new Wheel();
        $wheel->scroll(0, 100, $text, 500); //need to add waiting time because of scrolling is perform in asynchronously or we might get incorrect result.

        $session->performActions($wheel);

        $textScroll = $session->find('#text-scroll');

        static::assertEquals('TAREAx0y100', $textScroll->getProperty('value'));
    }

    public function testScreenshot(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->rect(0, 0, 1024, 768);

        $url = static::getWebBaseUri() . '/common.html';
        $session->navigateTo($url);

        $imgPath = static::getBaseTmpDir() . '/' . bin2hex(random_bytes(8)) . '.png';

        $file = $session->screenshotTo($imgPath);

        static::assertGreaterThan(15000, $file->getSize());
    }

    public function testPrintPDF(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/common.html';
        $session->navigateTo($url);

        $pdfPath = static::getBaseTmpDir()  . '/' . bin2hex(random_bytes(8)) . '.pdf';

        $file = $session->printTo($pdfPath);

        static::assertGreaterThan(15000, $file->getSize());
    }

    public function testSwitchFrame(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/frame.html';
        $session->navigateTo($url);

        $frame = $session->find('iframe');
        $session->switchToFrame($frame);

        static::assertEquals('common', $session->find('h1')?->getText());

        $session->switchToParentFrame();

        static::assertEquals('frame', $session->find('h1')?->getText());
    }

    public function testGetActiveElement(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $keyBoard = new Key();
        $keyBoard
            ->keyPress(CodePoint::Tab);

        $session->performActions($keyBoard);

        static::assertEquals('common', $session->getActiveElement()?->getText());
    }

    public function buildTestCookie(): Cookie
    {
        $out = new Cookie(bin2hex(random_bytes(4)), bin2hex(random_bytes(4)));
        $out->expiry =  strtotime('+3 days');
        $out->sameSite = CookieSameSite::Lax;
        $out->httpOnly = false;
        $out->secure = true;
        return $out;
    }

    public function testCookie(): void
    {
        $session = $this->getDriver()->newSession();

        $testCook = $this->buildTestCookie();

        $url = static::getWebBaseUri()
            .  sprintf(
                "/cookie.php?name=%s&value=%s&time=%d&secure=%d&httponly=%d&samesite=%s",
                $testCook->name,
                $testCook->value,
                $testCook->expiry,
                $testCook->secure,
                $testCook->httpOnly,
                $testCook->sameSite->value
            );

        $session->navigateTo($url);

        static::assertCount(1, $session->getCookies());

        $testCook1 = $this->buildTestCookie();

        $session->addCookie($testCook1);
        $session->addCookie($this->buildTestCookie());

        $cookie = $session->getCookie($testCook1->name);

        static::assertInstanceOf(Cookie::class, $cookie);
        static::assertEquals($testCook1->name, $cookie->name);
        static::assertEquals($testCook1->value, $cookie->value);
        static::assertEquals($testCook1->expiry, $cookie->expiry);
        static::assertEquals($testCook1->sameSite, $cookie->sameSite);
        static::assertEquals($testCook1->secure, $cookie->secure);
        static::assertEquals($testCook1->httpOnly, $cookie->httpOnly);

        $session->deleteCookie($testCook1->name);

        $cookie = $session->getCookie($testCook1->name);

        static::assertNull($cookie);

        $session->deleteCookies();

        static::assertCount(0, $session->getCookies());
    }

    public function testAlert(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri().'/alert.html';

        $session->navigateTo($url);

        $abtn = $session->find('#alert-btn');
        $abtn->click();

        $session->dismissAlert();

        $bbtn = $session->find('#confirm-btn');
        $bbtn->click();

        $session->acceptAlert();

        static::assertEquals('true', $bbtn->getText());

        $cbtn = $session->find('#prompt-btn');
        $cbtn->click();

        static::assertEquals('enter code', $session->getAlertText());

        $code = random_int(0,10000);
        $session->sendAlertText($code);
        $session->acceptAlert();

        static::assertEquals($code, $cbtn->getText());

    }
}
