<?php

namespace Rattananen\Webdriver\Capability;

use Rattananen\Webdriver\Entity\TimeoutsConfiguration;

class Capability implements \JsonSerializable
{

    public string $browserName;

    public ?string $platformName = null;

    public TimeoutsConfiguration $timeouts;

    public bool $acceptInsecureCerts = true;

    public array $browserOptions = [];

    public function jsonSerialize(): mixed
    {
        $out = [
            'browserName' => $this->browserName,
            'timeouts' =>  $this->timeouts,
            'acceptInsecureCerts' =>  $this->acceptInsecureCerts,
        ];

        if(isset($this->platformName)){
            $out['platformName'] = $this->platformName;
        }

        $out += $this->browserOptions;
        return $out;
    }
}
