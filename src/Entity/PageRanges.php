<?php

namespace Rattananen\Webdriver\Entity;

class PageRanges implements \JsonSerializable
{
    /**
     * @var Array<int|string>
     */
    private array $data = [];

    public function addPage(int ...$pages): static
    {
        $this->data += $pages;
        return $this;
    }

    public function addRange(int $from, int $to): static
    {
        $this->data[] = "$from-$to";
        return $this;
    }

    public function addFrom(int $from): static
    {
        $this->data[] = "$from-";
        return $this;
    }

    public function addTo(int $to): static
    {
        $this->data[] = "-$to";
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
