<?php

namespace Rattananen\Webdriver\Input\Actions\Traits;

trait KeyTrait
{
    public function __construct(
        private string $value
    ) {
        if (!\IntlChar::isdefined($this->value)) {
            throw new \InvalidArgumentException("Invalid codepoint.");
        }
    }

    abstract public function getType(): string;

    public function jsonSerialize(): mixed
    {
        return [
            'type' => $this->getType(),
            'value' => $this->value,
        ];
    }
}
