<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Types\W3C;

class ShadowRoot implements \JsonSerializable
{
    use FindElementTrait;

    private string $baseUri;

    public function __construct(
        private LocalEndInterface $driver,
        public readonly string $sessionId,
        public readonly string $shadowId
    ) {
        $this->baseUri = $this->driver->getBaseUri() . '/session/' . $this->sessionId . '/shadow/' . $this->shadowId;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getDriver(): LocalEndInterface
    {
        return $this->driver;
    }

    public function jsonSerialize(): mixed
    {
        return [W3C::SHADOW_ROOT_IDENTIFIER => $this->shadowId];
    }
}
