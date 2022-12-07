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

        Helper::assertStatusCode($res, 200);

        return Helper::decodeJsonResponse($res)['value'];
    }

    public function screenshotTo(string $filename): SplFileObject
    {
        $file = new SplFileObject($filename, 'w');
        $file->fwrite(base64_decode($this->screenshot()));
        return $file;
    }
}
