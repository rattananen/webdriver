<?php

namespace Rattananen\Webdriver;

class Script implements \JsonSerializable
{
    public function __construct(
        public string $script,
        public array $args = []
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'script' => $this->script,
            'args' => $this->args,
        ];
    }
}
