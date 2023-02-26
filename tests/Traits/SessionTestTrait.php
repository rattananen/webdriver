<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\Input\InputSources\Wheel;
use Rattananen\Webdriver\Input\InputSources\Pointer;
use Rattananen\Webdriver\Input\InputSources\Key;
use Rattananen\Webdriver\Types\CodePoint;

trait SessionTestTrait
{
    abstract public function getDriver(): LocalEndInterface;

    abstract public static function getWebBaseUri(): string;

    abstract public static function getBaseTmpDir(): string;

    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;

    abstract public static function assertNotEmpty($actual, string $message = ''): void;

    abstract public static function assertGreaterThan($expected, $actual, string $message = ''): void;

    abstract public static function assertEquals($expected, $actual, string $message = ''): void;


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

    public function testFindSlowElement(): void
    {
        $session = $this->getDriver()->newSession();
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
}
