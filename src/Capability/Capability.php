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

        $out = [
            'browserName' => $this->browserName,
            'platformName' =>  $this->platformName,
            'timeouts' =>  $this->timeouts,
            'acceptInsecureCerts' =>  $this->acceptInsecureCerts,
        ];

        $out += $this->browserOptions;
        return $out;
    }
}
