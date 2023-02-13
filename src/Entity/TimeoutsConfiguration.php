<?php

namespace Rattananen\Webdriver\Entity;

/**
 * https://www.w3.org/TR/webdriver/#dfn-timeouts-configuration
*/
class TimeoutsConfiguration implements \JsonSerializable
{
    /**
     * @param int $implicit We can use this value for wait element loading.
    */
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
