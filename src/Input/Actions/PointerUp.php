<?php

namespace Rattananen\Webdriver\Input\Actions;

use Rattananen\Webdriver\Types\PointerButton;
use Rattananen\Webdriver\Input\ActionInterface;
use Rattananen\Webdriver\Input\Actions\Traits\PointerTrait;

class PointerUp implements ActionInterface
{
    use PointerTrait;

    public function __construct(
        public PointerButton $button
    ) {
    }

    public function getType(): string
    {
        return 'pointerUp';
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => $this->getType(),
            'button' => $this->button
        ] + $this->getOptions();
    }

}
