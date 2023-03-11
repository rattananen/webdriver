<?php

namespace Rattananen\Webdriver\Entity;

/**
 * @see https://www.w3.org/TR/webdriver/#dfn-timeouts-configuration
 */
class TimeoutsConfiguration implements \JsonSerializable
{
    /**
     * @param int $implicit time in ms.
     */
    public function __construct(
        public ?int $script = 5000,
        public int $pageLoad = 5000,
        public int $implicit = 3000
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static($data['script'], $data['pageLoad'], $data['implicit']);
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
