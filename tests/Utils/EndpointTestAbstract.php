<?php

namespace Rattananen\Webdriver\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Session;
use Rattananen\Webdriver\Entity\DriverStatusInterface;
use Rattananen\Webdriver\Element;

abstract class EndpointTestAbstract extends TestCase
{
    abstract public function getDriver(): LocalEndInterface;

    public static Process $serverProcess;

    public static string $webhost = 'localhost:8878';

    public static string $tmpTestDir;

    public static function setUpBeforeClass(): void
    {
        if (!isset(static::$serverProcess)) {
            static::$serverProcess = new Process([
                'php',
                '-S',
                static::$webhost,
                '-t',
                __DIR__ . '/../Resources/web'
            ]);
            static::$serverProcess->start();
            \usleep(80000);

            if (!self::$serverProcess->isRunning()) {
                throw new \LogicException(self::$serverProcess->getErrorOutput());
            }
        }

        //static::$tmpTestDir = sys_get_temp_dir() . '/wdtest';
        static::$tmpTestDir  = __DIR__ . '/../Resources/web/cap_test';
        if (!is_dir(static::$tmpTestDir)) {
            mkdir(static::$tmpTestDir);
        }
    }

    public static function tearDownAfterClass(): void
    {
        static::$serverProcess->stop();

        //remove tmp folder
        if (is_dir(static::$tmpTestDir)) {
            $it = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(static::$tmpTestDir, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_FILEINFO),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($it as $file) {
                if ($file->isDir()) {
                    rmdir($file->getPathName());
                } else {
                    unlink($file->getPathName());
                }
            }

            rmdir(static::$tmpTestDir);
        }
    }

    /**
     * start local end test
     */
    public function testNewSession(): void
    {
        $session = $this->getDriver()->newSession();

        $this->assertInstanceOf(Session::class, $session);
    }

    public function testStatus(): void
    {
        $status = $this->getDriver()->status();

        $this->assertInstanceOf(DriverStatusInterface::class, $status);
    }

    /**
     * start window test
     */
    public function testRect(): void
    {
        $session = $this->getDriver()->newSession();

        $session->window->rect(1, 2, 1024, 768);

        $rect = $session->window->getRect();

        $this->assertEquals(1, $rect->x);
        $this->assertEquals(2, $rect->y);
        $this->assertEquals(1024, $rect->width);
        $this->assertEquals(768, $rect->height);
    }

    /**
     * start session test 
     * 
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
        $url = 'http://' . static::$webhost . '/img.html';
        $session->navigateTo($url);

        $result = $session->getCurrentUrl();

        $this->assertEquals($url, $result);
    }

    public function testSimpleJavascript(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/js.html';
        $session->navigateTo($url);

        $result = $session->js('const [a, b] = arguments;return a+b;', [4, 6]);

        $this->assertEquals(10, $result);

        $result = $session->jsAsync('const [a, b, c, d, resolve] = arguments;resolve(window.TestJs.sum(a, b, c, d));', [1, 2, 3, 4]);

        $this->assertEquals(10, $result);
    }

    public function testScreenshot(): void
    {
        $session = $this->getDriver()->newSession();
        $session->window->rect(0, 0, 1024, 768);

        $url = 'http://' . static::$webhost . '/common.html';
        $session->navigateTo($url);

        $imgPath = static::$tmpTestDir . '/' . bin2hex(random_bytes(8)) . '.png';

        $file = $session->screenshotTo($imgPath);

        $this->assertGreaterThan(15000, $file->getSize());
    }

    public function testPrintPDF(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/common.html';
        $session->navigateTo($url);

        $pdfPath = static::$tmpTestDir . '/' . bin2hex(random_bytes(8)) . '.pdf';

        $file = $session->printTo($pdfPath);

        $this->assertGreaterThan(15000, $file->getSize());
    }

    public function testFindSlowElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/js.html';

        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        $this->assertInstanceOf(Element::class, $elem);
    }

    public function testFindElements(): void
    {
        $session = $this->getDriver()->newSession();

        $url = 'http://' . static::$webhost . '/common.html';

        $session->navigateTo($url);

        $elements = $session->findAll('.common-img');

        $this->assertInstanceOf(Element::class, $elements[0]);
    }

    public function testGetPageSource():void
    {
        $session = $this->getDriver()->newSession();
        
        $url = 'http://' . static::$webhost . '/common.html';

        $session->navigateTo($url);

        $this->assertNotEmpty($session->getPageSource());
    }


    /**
     * start element test 
     */

    public function testGetText(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/common.html';
        $session->navigateTo($url);

        $elem = $session->find('.left');

        $this->assertEquals('Left Menu', $elem->getText());
    }

    public function testFindInsideElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/common.html';

        $session->navigateTo($url);

        $elem = $session->find('.main');

        $this->assertInstanceOf(Element::class, $elem->find('.common-img'));
    }

    public function testFindAllInsideElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/common.html';

        $session->navigateTo($url);

        $elem = $session->find('.main');

        $this->assertInstanceOf(Element::class, $elem->findAll('.common-img')[0]);
    }

    public function testScreenshotElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://' . static::$webhost . '/common.html';

        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        $imgPath = static::$tmpTestDir . '/' . bin2hex(random_bytes(8)) . '.png';

        $file = $elem->screenshotTo($imgPath);

        $this->assertGreaterThan(3000, $file->getSize());
    }

    public function testElementRect(): void
    {
        $session = $this->getDriver()->newSession();

        $url = 'http://' . static::$webhost . '/common.html';
        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        $rect = $elem->getRect();

        //x, y might be different for each browser
        $this->assertEquals(400, $rect->width);
        $this->assertEquals(150, $rect->height);
    }

    public function testElementProps(): void
    {
        $session = $this->getDriver()->newSession();

        $url = 'http://' . static::$webhost . '/common.html';
        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        $this->assertEquals("img", $elem->getTagName());

        $this->assertEquals("common img", $elem->getAttribute('title'));

        $this->assertEquals('http://' . static::$webhost."/400x150.png", $elem->getProperty('src'));

        $this->assertEquals("400px", $elem->getCssValue('width'));
    }

    public function testElementClick():void
    {
        $session = $this->getDriver()->newSession();

        $url = 'http://' . static::$webhost . '/input.html';
        $session->navigateTo($url);

        $btn = $session->find('.btn-test');
        $btn->click();

        $this->assertEquals('clicked', $btn->getText());
    }

    public function testElementSendKeysAndClear():void
    {
        $session = $this->getDriver()->newSession();

        $url = 'http://' . static::$webhost . '/input.html';
        $session->navigateTo($url);

        $elem = $session->find('#text-a');
        $elem->sendKeys('aeiouß');

        $this->assertEquals('aeiouß', $elem->getProperty('value'));

        $elem->clear();

        $this->assertEquals('', $elem->getProperty('value'));
    }

    
}
