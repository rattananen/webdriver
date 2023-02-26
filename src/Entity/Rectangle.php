<?php

namespace Rattananen\Webdriver\Entity;

class Rectangle implements \JsonSerializable
{
    public function __construct(
        public float $x,
        public float $y,
        public float $width,
        public float $height
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

    public static function fromArray(array $data): static
    {
        return new static($data['x'], $data['y'], $data['width'], $data['height']);
    }
}
