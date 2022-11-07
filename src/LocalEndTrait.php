<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client;
use Rattananen\Webdriver\Capability\Capabilities;

trait LocalEndTrait
{

    abstract public function getClient(): Client;

    public function newSession(?Capabilities $capabilities = null): Session
    {
        $res = $this->getClient()->post('session', ['body' => json_encode($capabilities ?? static::getDefaultCapabilities())]);
        $data = Helper::decodeJsonResponse($res);
        return new Session($this, $data['value']['sessionId']);
    }

    public function status(): int
    {
        return Helper::decodeJsonResponse($this->getClient()->get('status'))['value']['ready'] ;
    }

}
