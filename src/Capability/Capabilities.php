<?php

namespace Jkk\Webdriver\Capability;

class Capabilities implements \JsonSerializable
{
    public Capability $alwaysMatch;

    /** @var Capability[] $firstMatch */
    public array $firstMatch = [];

    public function jsonSerialize(): mixed
    {
        $out = [
            'capabilities' => []
        ];
        if(isset($this->alwaysMatch)){
            $out['capabilities']['alwaysMatch'] = $this->alwaysMatch;
        }
        if(count($this->firstMatch) > 0){
            $out['capabilities']['firstMatch'] = $this->firstMatch;
        }
        return $out;
    }
}