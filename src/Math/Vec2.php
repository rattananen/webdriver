<?php

namespace Rattananen\Webdriver\Math;

class Vec2
{
    public function __construct(
        public float $x,
        public float $y
    ) {
    }


    public function rotate(float $rad): static
    {
        $cos = cos($rad);
        $sin = sin($rad);
        $this->x = $this->x * $cos - $this->y * $sin;
        $this->y = $this->x * $sin + $this->y * $cos;
        return $this;
    }

    public function rotateAround(float $rad, Vec2 $origin): static
    {
        $this->x -= $origin->x;
        $this->y -= $origin->y;

        $cos = cos($rad);
        $sin = sin($rad);

        $x1 = $this->x * $cos - $this->y * $sin;
        $y1 = $this->x * $sin + $this->y * $cos;

        $this->x = $x1 + $origin->x;
        $this->y = $y1 + $origin->y;

        return $this;
    }

    public function add(Vec2 $other): static
    {
        $this->x += $other->x;
        $this->y += $other->y;
        return $this;
    }

    public function clone(): static
    {
        return clone $this;
    }

    public function unproject(float $height): static
    {
        return new Vec2($this->x, $height - $this->y);
    }
}
