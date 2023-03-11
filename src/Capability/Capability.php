<?php

namespace Rattananen\Webdriver\Capability;

use Rattananen\Webdriver\Entity\TimeoutsConfiguration;
use Rattananen\Webdriver\Entity\PageLoadStrategy;
use Rattananen\Webdriver\Entity\UnhandledPromptBehavior;

class Capability implements \JsonSerializable
{

    public string $browserName;

    public ?string $platformName = null;

    public TimeoutsConfiguration $timeouts;

    public bool $acceptInsecureCerts = true;

    public ?PageLoadStrategy $pageLoadStrategy = null;

    public ?UnhandledPromptBehavior $unhandledPromptBehavior = null;

    public bool $strictFileInteractability = false;

    public array $extendOptions = [];

    public function jsonSerialize(): mixed
    {
        $out = [
            'browserName' => $this->browserName,
            'timeouts' =>  $this->timeouts,
            'acceptInsecureCerts' =>  $this->acceptInsecureCerts,
            'strictFileInteractability' => $this->strictFileInteractability
        ];

        if(isset($this->platformName)){
            $out['platformName'] = $this->platformName;
        }

        if(isset($this->pageLoadStrategy)){
            $out['pageLoadStrategy'] = $this->pageLoadStrategy;
        }

        if(isset($this->unhandledPromptBehavior)){
            $out['unhandledPromptBehavior'] = $this->unhandledPromptBehavior;
        }

        $out += $this->extendOptions;
        return $out;
    }
}
