<?php

namespace Rattananen\Webdriver\Input\InputSources;

use Rattananen\Webdriver\Input\InputSourceInterface;

class Key implements InputSourceInterface
{

    

    public function getType(): string
    {
        return 'key';
    }

    public function getId(): string
    {
        return '';
    }

    public function jsonSerialize(): mixed
    {
        $out = [
            'type' => $this->getType(),
            'id' => $this->getId()
        ];
        return  $out;
    }
}
