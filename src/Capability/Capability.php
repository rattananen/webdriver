<?php

namespace Rattananen\Webdriver\Capability;

use Rattananen\Webdriver\Entity\TimeoutsConfiguration;

class Capability implements \JsonSerializable
{

    public string $browserName;

    public string $platformName;

    public TimeoutsConfiguration $timeouts;

    public bool $acceptInsecureCerts = true;

    public array $browserOptions = [];

    public function jsonSerialize(): mixed
    {
        $out = [];
        //Reflection Class is consume more resource don't use them often
        foreach (static::getClassMeta() as $k) {
            if (isset($this->{$k})) {
                $out[$k] = $this->{$k};
            }
        }

        $out += $this->browserOptions;
        return $out;
    }

  
    public static function getClassMeta(): array
    {
        return [
            'browserName',
            'platformName',
            'timeouts',
            'acceptInsecureCerts'
        ];
    }
}
