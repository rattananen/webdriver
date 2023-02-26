<?php

namespace Rattananen\Webdriver\Input\InputSources;

use Rattananen\Webdriver\Input\InputSourceInterface;
use Rattananen\Webdriver\Input\InputSourceTrait;
use Rattananen\Webdriver\Input\Actions\KeyDown;
use Rattananen\Webdriver\Input\Actions\KeyUp;

class Key implements InputSourceInterface
{
    
    use InputSourceTrait;

    public function __construct(?string $id = null)
    {
        $this->id = $id ?? 'key-' . bin2hex(random_bytes(6));
    }

    public function getType(): string
    {
        return 'key';
    }

    public function jsonSerialize(): mixed
    {
        return  [
            'type' => $this->getType(),
            'id' => $this->id,
            'actions' => $this->actions
        ];
    }

    public function keyUp(string $key): static
    {
        $this->actions[] = new KeyUp($key);
        return $this;
    }

    public function keyDown(string $key): static
    {
        $this->actions[] = new KeyDown($key);
        return $this;
    }

    public function keyPress(string $key): static
    {
        $this->actions[] = new KeyDown($key);
        $this->actions[] = new KeyUp($key);
        return $this;
    }
}
