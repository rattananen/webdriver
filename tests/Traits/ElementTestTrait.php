<?php

namespace Rattananen\Webdriver\Tests\Traits;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\ShadowRoot;
use Rattananen\Webdriver\Entity\FileList;

trait ElementTestTrait
{
    abstract public function getDriver(): LocalEndInterface;

    abstract public static function getWebBaseUri(): string;

    abstract public static function getBaseTmpDir(): string;

    abstract public static function assertEquals($expected, $actual, string $message = ''): void;

    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;

    abstract public static function assertGreaterThan($expected, $actual, string $message = ''): void;

    public function testGetText(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/common.html';
        $session->navigateTo($url);

        $elem = $session->find('.left');

        static::assertEquals('Left Menu', $elem->getText());
    }

    public function testFindInsideElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri()  . '/common.html';

        $session->navigateTo($url);

        $elem = $session->find('.main');

        static::assertInstanceOf(Element::class, $elem->find('.common-img'));
    }

    public function testFindAllInsideElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $elem = $session->find('.main');

        static::assertInstanceOf(Element::class, $elem->findAll('.common-img')[0]);
    }

    public function testScreenshotElement(): void
    {
        $session = $this->getDriver()->newSession();
        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        $imgPath = static::getBaseTmpDir() . '/' . bin2hex(random_bytes(8)) . '.png';

        $file = $elem->screenshotTo($imgPath);

        static::assertGreaterThan(3000, $file->getSize());
    }

    public function testElementRect(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';
        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        $rect = $elem->getRect();

        //x, y might be different for each browser
        static::assertEquals(400, $rect->width);
        static::assertEquals(150, $rect->height);
    }

    public function testElementProps(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';
        $session->navigateTo($url);

        $elem = $session->find('.common-img');

        static::assertEquals("img", $elem->getTagName());

        static::assertEquals("common img", $elem->getAttribute('title'));

        static::assertEquals(static::getWebBaseUri() . "/400x150.png", $elem->getProperty('src'));

        static::assertEquals("400px", $elem->getCssValue('width'));
    }

    public function testElementClick(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/input.html';
        $session->navigateTo($url);

        $btn = $session->find('#btn-test1');
        $btn->click();

        static::assertEquals('clicked', $btn->getText());
    }

    public function testElementSendKeysAndClear(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/file.html';
        $session->navigateTo($url);

        $file = $session->find('#file-input');
        $counter = $session->find('#counter');

        $files = new FileList();
        $files[] = __DIR__ . '/../Resources/web/1920x1080.png';
        $files[] = __DIR__ . '/../Resources/web/800x600.png';

        $file->sendKeys($files);

        static::assertEquals('2', $counter->getText());

        $file->clear();

        static::assertEquals('0', $counter->getText());
    }

    public function testElementState(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $checkbox = $session->find('#test-checkbox');

        static::assertEquals(true,  $checkbox->isEnabled());

        static::assertEquals(true,  $checkbox->isSelected());
    }

    public function testAccessibilityEndpoint(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/common.html';

        $session->navigateTo($url);

        $checkbox = $session->find('#test-checkbox');

        static::assertEquals('checkbox',  $checkbox->getComputedRole());

        static::assertEquals('checkbox label',  $checkbox->getComputedLabel());
    }

    public function testShadowElement(): void
    {
        $session = $this->getDriver()->newSession();

        $url = static::getWebBaseUri() . '/shadow.html';

        $session->navigateTo($url);

        $elem = $session->find('date-info');

        $root = $elem->getShadowRoot();

        static::assertInstanceOf(ShadowRoot::class, $root);

        static::assertEquals('1995',  $root->find('.year')?->getText());
    }
}
