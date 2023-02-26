<?php

namespace Rattananen\Webdriver;

use GuzzleHttp\Client as BaseClient;
use Psr\Http\Message\ResponseInterface;

/**
 * default client
 * 
 * @final
 * 
 * @internal 
 *
 */
class Client implements ClientInterface
{
    private BaseClient $client;
    public function __construct()
    {
        if (!class_exists(BaseClient::class)) {
            throw new \LogicException("Package guzzlehttp/guzzle is required for default client.");
        }
        $this->client = new BaseClient([
            'http_errors' => false,
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    public function delete(string $uri): ResponseInterface
    {
        return $this->client->delete($uri);
    }

    public function get(string $uri): ResponseInterface
    {
        return $this->client->get($uri);
    }

    public function post(string $uri, mixed $data = null): ResponseInterface
    {
        return $this->client->post($uri, ['body' => isset($data) ? json_encode($data) : '{}']);
    }
}
