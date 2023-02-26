<?php

namespace Rattananen\Webdriver\Input\Actions;

use Rattananen\Webdriver\Input\ActionInterface;

class Pause implements ActionInterface
{

    public function __construct(
        public ?int $duration = null 
    ){}

    public function getType(): string
    {
        return 'pause';
    }

    public function jsonSerialize(): mixed
    {
        $out = [
            'type' => $this->getType()
        ];
        if(isset($this->duration)){
            $out['duration'] = $this->duration;
        }
        return $out;
    }
}
