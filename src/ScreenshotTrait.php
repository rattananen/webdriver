<?php

namespace Rattananen\Webdriver;

use SplFileObject;

trait ScreenshotTrait
{

    abstract public function getBasePath(): string;

    abstract public function getDriver(): LocalEndInterface;

    /**
     * @return SplFileObject|string|false return PNG in non-urlsafe base64 or SplFileObject if $filename set or false if error
     */
    public function screenshot(?string $filename = null): SplFileObject|string|false
    {
        $res = $this->getDriver()->getClient()->get($this->getBasePath() . '/screenshot');

        // let user decide that should they stop or not.
        if ($res->getStatusCode() >= 400) {
            return false;
        }

        $data = Helper::decodeJsonResponse($res);

        if ($filename === null) {
            return $data['value'];
        }

        $file = new SplFileObject($filename, 'w');
        $file->fwrite(base64_decode($data['value']));
        return $file;
    }
}
