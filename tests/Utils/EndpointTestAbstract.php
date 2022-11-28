<?php

namespace Rattananen\Webdriver\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\Session;
use Rattananen\Webdriver\Entity\DriverStatusInterface;
use Rattananen\Webdriver\Entity\Rectangle;
use Rattananen\Webdriver\Entity\Script;


abstract class EndpointTestAbstract extends TestCase
{
    abstract public function getDriver(): LocalEndInterface;


    public static Process $serverProcess;

    public static string $webhost = 'localhost:8878';

    public static function setUpBeforeClass(): void
    {
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

    public static function tearDownAfterClass(): void
    {
        static::$serverProcess->stop();
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
     * start session test 
     * 
     * @doesNotPerformAssertions
     */
    public function testDelete(): void
    {
        $session = $this->getDriver()->newSession();

        $session->delete();
    }

    public function testNavigate():void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://'.static::$webhost.'/img.html';
        $session->navigateTo($url);

        $result = $session->getCurrentUrl();

        $this->assertEquals($url, $result);
    }

    public function testSimpleJavascript():void
    {
        $session = $this->getDriver()->newSession();
        $url = 'http://'.static::$webhost.'/js.html';
        $session->navigateTo($url);

        $result = $session->execute(new Script('const [a, b] = arguments;return a+b;', [4, 6]));
        
        $this->assertEquals(10, $result);

        $result = $session->executeAsync(new Script('const [a, b, c, d, resolve] = arguments;resolve(window.TestJs.sum(a, b, c, d));', [1, 2, 3, 4]));
    
        $this->assertEquals(10, $result);
    }
  
    /**
     * start window test
    */
    public function testRect(): void
    {
        $session = $this->getDriver()->newSession();

        $session->window->setRect(new Rectangle(1, 2, 1024, 768));

        $rect = $session->window->getRect();

        $this->assertEquals(1, $rect->x);
        $this->assertEquals(2, $rect->y);
        $this->assertEquals(1024, $rect->width);
        $this->assertEquals(768, $rect->height);
    }
}
