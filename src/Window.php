<?php

namespace Jkk\Webdriver;

class Window
{
    private string $basePath;

    public function __construct(
        private DriverInterface $driver,
        private string $sessionId
    ) {
        $this->basePath = 'session/' . $this->sessionId.'/window';
    }

   
}