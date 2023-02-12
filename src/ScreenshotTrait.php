<?php

namespace Rattananen\Webdriver;

use SplFileObject;

trait ScreenshotTrait
{

    abstract public function getBasePath(): string;

    abstract public function getDriver(): LocalEndInterface;

    public function screenshot(): string
    {
        $res = $this->getDriver()->getClient()->get($this->getBasePath() . '/screenshot');

        return Helper::assertAndGetValue($res, 200);
    }

    public function screenshotTo(string $filename): SplFileObject
    {
        $bin = base64_decode($this->screenshot());//write to memory first to prevert create empty file when error

        $file = new SplFileObject($filename, 'w');
        $file->fwrite($bin);
        return $file;
    }
}
