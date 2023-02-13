<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Capability\Capabilities;
use Rattananen\Webdriver\Entity\DriverStatusInterface;
use Rattananen\Webdriver\Entity\DriverStatus;

trait LocalEndTrait
{

    abstract public function getBaseUri(): string;

    abstract public function getClient(): ClientInterface;

    public function newSession(?Capabilities $capabilities = null): Session
    {
        $res = $this->getClient()->post($this->getBaseUri() . '/session',  $capabilities ?? static::getDefaultCapabilities());
        $data = Helper::assertAndGetValue($res, 200);
        return new Session($this, $data['sessionId']);
    }

    public function status(): DriverStatusInterface
    {
        $res =  $this->getClient()->get($this->getBaseUri() .'/status');
        $data = Helper::decodeJsonResponse($res);
        return DriverStatus::fromArray($data['value']);
    }
}
