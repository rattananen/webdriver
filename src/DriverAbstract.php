<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client;

abstract class DriverAbstract implements DriverInterface
{
    use DriverTrait;

    public function __construct(string $host = 'localhost:9515')
    {
        $this->client = new Client([
            'base_uri' => 'http://' . $host,
            'http_errors' => false,
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }
}
