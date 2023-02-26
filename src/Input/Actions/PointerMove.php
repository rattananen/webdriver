<?php

namespace Rattananen\Webdriver\Input\Actions;


use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\Types\Origin;
use Rattananen\Webdriver\Input\ActionInterface;
use Rattananen\Webdriver\Input\Actions\Traits\PointerTrait;

class PointerMove implements ActionInterface
{
    use PointerTrait;

    public function __construct(
        public int $x,
        public int $y,
        public Origin|Element|null $origin = null,
        public ?int $duration = null
    )
    {
        
    }

    public function getType(): string
    {
        return 'pointerMove';
    }

    public function jsonSerialize(): mixed
    {
        $out =  [
            'type' => $this->getType(),
            'x' => $this->x,
            'y' => $this->y
        ];
        if(isset($this->origin)){
            $out['origin'] = $this->origin;
        }
        if(isset($this->duration)){
            $out['duration'] = $this->duration;
        }
        return $out + $this->getOptions();
    }
}
