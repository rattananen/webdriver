<?php

namespace Rattananen\Webdriver\Tests;

use PHPUnit\Framework\TestCase;

class LazyTest extends TestCase
{
    public function testLazy():void
    {
        $this->assertEquals('lazy', 'yes');
    }
}