<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client;
use Rattananen\Webdriver\Capability\Capabilities;
use Rattananen\Webdriver\Entity\DriverStatusInterface;

interface LocalEndInterface
{
    public function newSession(?Capabilities $capabilities = null): Session;

    public function status(): DriverStatusInterface;

    public function getClient(): Client;

    public static function getDefaultCapabilities(): Capabilities;
}
