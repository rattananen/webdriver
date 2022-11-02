<?php

namespace Rattananen\Webdriver\Entity;

class TimeoutsConfiguration implements \JsonSerializable
{
    public function __construct(
        public ?int $script = 5000,
        public int $pageLoad = 7000,
        public int $implicit = 4000
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'script' => $this->script,
            'pageLoad' => $this->pageLoad,
            'implicit' => $this->implicit
        ];
    }
}
