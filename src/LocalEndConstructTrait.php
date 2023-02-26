<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Exception\WebdriverException;

trait LocalEndConstructTrait
{
    private ClientInterface $client;

    private string $baseUri;

    public function __construct(
        string $host = 'localhost:9515',
        bool $testConnection = true,
        ?ClientInterface $client = null
    ) {
        $this->baseUri = 'http://' . $host;

        $this->client = $client ?? new Client();

        if ($testConnection) {
            try {
                $this->status();
            } catch (\Throwable $th) {
                throw new WebdriverException(sprintf("Error while connect %s.", $this->baseUri), 0, $th);
            }
        }
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
