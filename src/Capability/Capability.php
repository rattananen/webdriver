<?php

namespace Jkk\Webdriver\Capability;

use Jkk\Webdriver\TimeoutsConfiguration;

class Capability implements \JsonSerializable
{

    public string $browserName;

    public TimeoutsConfiguration $timeouts;

    public array $extraOptions = [];

    public function jsonSerialize(): mixed
    {
        $out = [];
        /** Reflection Class is slower don't use them often */
        foreach (static::getClassMetaData() as $k) {
            if (isset($this->{$k})) {
                $out[$k] = $this->{$k};
            }
        }

        $out += $this->extraOptions;
        return $out;
    }

  
    public static function getClassMetaData(): array
    {
        return [
            'browserName',
            'timeouts'
        ];
    }
}