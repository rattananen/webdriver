<?php

namespace Rattananen\Webdriver\Entity;

class DriverStatus implements DriverStatusInterface
{

    public function __construct(
        public string $message,
        public bool $ready
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getReady(): bool
    {
        return $this->ready;
    }

    public static function fromArray(array $data): static
    {
        return new static($data['message'], $data['ready']);
    }
}
