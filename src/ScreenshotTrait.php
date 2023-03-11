<?php

namespace Rattananen\Webdriver;

use SplFileObject;

trait ScreenshotTrait
{

    abstract public function getBaseUri(): string;

    abstract public function getDriver(): LocalEndInterface;

    public function screenshot(): string
    {
        $res = $this->getDriver()->getClient()->get($this->getBaseUri() . '/screenshot');

        return Utils::getStatusOkValue($res);
    }

    public function screenshotTo(string $filename): SplFileObject
    {
        $bin = base64_decode($this->screenshot());//write to memory first to prevert create empty file when error

        $file = new SplFileObject($filename, 'w');
        $file->fwrite($bin);
        return $file;
    }
}
