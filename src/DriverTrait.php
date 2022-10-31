<?php

namespace Jkk\Webdriver;

use GuzzleHttp\Client;
use Jkk\Webdriver\Capability\Capabilities;

trait DriverTrait
{
    private Client $client;

    public function newSession(?Capabilities $caps = null): Session
    {
        $res = $this->client->post('session', ['body' => json_encode($caps ?? static::getDefaultCapabilities())]);
        $data = Helper::decodeJsonResponse($res);
        return new Session($this, $data['value']['sessionId']);
    }

    public function status(): int
    {
        return Helper::decodeJsonResponse($this->client->get('status'))['value']['ready'] ;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

}
