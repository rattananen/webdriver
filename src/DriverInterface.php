<?php

namespace Jkk\Webdriver;

use GuzzleHttp\Client;
use Jkk\Webdriver\Capability\Capabilities;

interface DriverInterface
{
    public function newSession(?Capabilities $caps = null): Session;

    public function status(): int;

    public function getClient(): Client;

    public static function getDefaultCapabilities(): Capabilities;
}
