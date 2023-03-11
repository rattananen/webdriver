<?php

namespace Rattananen\Webdriver\Entity;

use Rattananen\Webdriver\Types\WindowType;

class WindowInfo
{
    public string $handle;
    public WindowType $type;

    public static function fromArray(array $data): static
    {
        $out = new static();
        $out->handle = $data['handle'];
        $out->type = WindowType::from($data['type']);

        return $out;
    }
}
