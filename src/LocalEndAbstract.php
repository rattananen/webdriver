<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client;

abstract class LocalEndAbstract implements LocalEndInterface
{
    use LocalEndTrait;

    private Client $client;

    public function __construct(string $host = 'localhost:9515')
    {
        $this->client = new Client([
            'base_uri' => 'http://' . $host,
            'http_errors' => false,
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
