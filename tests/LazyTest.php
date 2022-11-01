<?php

use PHPUnit\Framework\TestCase;

class LazyTest extends TestCase
{
    public function testCommon():void
    {
        $this->assertEquals('lazy', 'yes');
    }
}