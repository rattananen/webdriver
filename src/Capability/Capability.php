<?php

namespace Rattananen\Webdriver\Capability;

use Rattananen\Webdriver\Entity\TimeoutsConfiguration;
use Rattananen\Webdriver\Entity\PageLoadStrategy;
use Rattananen\Webdriver\Entity\UnhandledPromptBehavior;

class Capability implements \JsonSerializable
{

    public ?string $browserName;

    public ?string $browserVersion;

    public ?string $platformName;

    public ?TimeoutsConfiguration $timeouts;

    public ?bool $acceptInsecureCerts;

    public ?PageLoadStrategy $pageLoadStrategy;

    public ?UnhandledPromptBehavior $unhandledPromptBehavior;

    public ?bool $strictFileInteractability;

    public array $extendOptions = [];

    public function jsonSerialize(): mixed
    {
        $out = [];

        if (isset($this->browserName)) {
            $out['browserName'] = $this->browserName;
        }

        if (isset($this->browserVersion)) {
            $out['browserVersion'] = $this->browserVersion;
        }

        if (isset($this->timeouts)) {
            $out['timeouts'] = $this->timeouts;
        }

        if (isset($this->acceptInsecureCerts)) {
            $out['acceptInsecureCerts'] = $this->acceptInsecureCerts;
        }

        if (isset($this->strictFileInteractability)) {
            $out['strictFileInteractability'] = $this->strictFileInteractability;
        }

        if (isset($this->platformName)) {
            $out['platformName'] = $this->platformName;
        }

        if (isset($this->pageLoadStrategy)) {
            $out['pageLoadStrategy'] = $this->pageLoadStrategy;
        }

        if (isset($this->unhandledPromptBehavior)) {
            $out['unhandledPromptBehavior'] = $this->unhandledPromptBehavior;
        }

        if (count($out) == 0) {
            throw new \LogicException("Capability is empty.");
        }

        $out += $this->extendOptions;
        return $out;
    }
}
