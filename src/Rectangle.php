<?php

namespace Rattananen\Webdriver;

class Rectangle implements \JsonSerializable
{
    public function __construct(
        public ?int $x,
        public ?int $y,
        public ?int $width,
        public ?int $height
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

    public static function fromArray(array $a): static
    {
        return new static($a['x'], $a['y'], $a['width'], $a['height']);
    }
}
