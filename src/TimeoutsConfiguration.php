<?php

namespace Jkk\Webdriver;

class TimeoutsConfiguration implements \JsonSerializable
{
    public ?int $script = 30000;

    public int $pageLoad = 300000;

    public int $implicit = 0;

    public function jsonSerialize(): mixed
    {
        return [
            'script' => $this->script,
            'pageLoad' => $this->pageLoad,
            'implicit' => $this->implicit
        ];
    }
}
