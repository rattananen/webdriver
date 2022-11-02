<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client;
use Rattananen\Webdriver\Capability\Capabilities;

interface DriverInterface
{
    public function newSession(?Capabilities $capabilities = null): Session;

    public function status(): int;

    public function getClient(): Client;

    public static function getDefaultCapabilities(): Capabilities;
}
