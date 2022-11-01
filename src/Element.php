<?php

namespace Jkk\Webdriver;

use SplFileObject;

class Element
{
    private string $basePath;
    public function __construct(
        private DriverInterface $driver,
        private string $sessionId,
        private string $elementId
    ) {
        $this->basePath = 'session/' . $this->sessionId . '/element/' . $this->elementId;
    }

    public function text(): string
    {
        $res = $this->driver->getClient()->get($this->basePath . '/text');
        //$data = Helper::decodeJsonResponse($res);
        return Helper::decodeJsonResponse($res)['value'];
    }

    /**
     * @return SplFileObject|string|false return PNG in non-urlsafe base64 or SplFileObject if $filename set or false if error
     */
    public function screenshot(?string $filename = null): SplFileObject|string|false
    {
        $res = $this->driver->getClient()->get($this->basePath . '/screenshot');
      
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
