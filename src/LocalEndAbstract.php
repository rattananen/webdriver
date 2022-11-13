<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Rattananen\Webdriver\Exception\WebdriverException;

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

        try {
            $this->status();
        } catch (ConnectException $e) {
            throw new WebdriverException("Cann't connect http://$host.");
        }
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
