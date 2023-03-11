<?php

namespace Rattananen\Webdriver\Entity;

use Rattananen\Webdriver\Types\CookieSameSite;

class Cookie implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public string $value,
        public string $path = '/',
        public ?string $domain = null,
        public bool $secure = false,
        public bool $httpOnly = false,
        public int $expiry = 0,
        public ?CookieSameSite $sameSite = null,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        $out = [
            'name' => $this->name,
            'value' => $this->value,
            'path' => $this->path,
            'secure' => $this->secure,
            'httpOnly' => $this->httpOnly,
            'expiry' => $this->expiry
        ];
        if (isset($this->domain)) {
            $out['domain'] = $this->domain;
        }
        if (isset($this->sameSite)) {
            $out['sameSite'] = $this->sameSite;
        }
        return $out;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['name'],
            $data['value'],
            $data['path'],
            $data['domain'],
            $data['secure'],
            $data['httpOnly'],
            $data['expiry'] ?? 0,
            isset($data['sameSite']) ? CookieSameSite::from($data['sameSite']) : null
        );
    }
}
