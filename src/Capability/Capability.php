<?php

namespace Rattananen\Webdriver\Capability;

use Rattananen\Webdriver\Entity\TimeoutsConfiguration;

class Capability implements \JsonSerializable
{

    public string $browserName;

    public string $platformName;

    public TimeoutsConfiguration $timeouts;

    public bool $acceptInsecureCerts = true;

    public array $extraOptions = [];

    public function jsonSerialize(): mixed
    {
        $out = [];
        //Reflection Class is consume more resource don't use them often
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
            'platformName',
            'timeouts',
            'acceptInsecureCerts'
        ];
    }
}
