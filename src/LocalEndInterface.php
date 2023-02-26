<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Capability\Capabilities;
use Rattananen\Webdriver\Entity\DriverStatusInterface;

interface LocalEndInterface
{

    public function getBaseUri(): string;

    public function newSession(?Capabilities $capabilities = null): Session;

    public function status(): DriverStatusInterface;

    public function getClient(): ClientInterface;

    public static function getDefaultCapabilities(): Capabilities;
}
