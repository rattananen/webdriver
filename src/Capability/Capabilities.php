<?php

namespace Rattananen\Webdriver\Capability;

class Capabilities implements \JsonSerializable
{
    /**
     * @param Capability[] $firstMatch
    */
    public function __construct(
        public Capability $alwaysMatch,
        public array $firstMatch = []
        ){ 
    }

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