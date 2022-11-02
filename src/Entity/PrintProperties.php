<?php

namespace Rattananen\Webdriver\Entity;

class PrintProperties implements \JsonSerializable
{
    public function __construct(
        public float $pageWidth = 21.59, //cm
        public float $pageHeight  = 27.94,
        public float $marginTop = 1,
        public float $marginRight = 1,
        public float $marginBottom = 1,
        public float $marginLeft = 1,
        public PrintOrientation $orientation = PrintOrientation::portrait,
        public float $scale = 1,
        public bool $shrinkToFit = true,
        public bool $background = true,
        public array $pageRanges = []
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'page' => [
                'width' => $this->pageWidth,
                'height' => $this->pageHeight,
            ],
            'margin' => [
                'top' => $this->marginTop,
                'right' => $this->marginRight,
                'bottom' => $this->marginBottom,
                'left' => $this->marginLeft
            ],
            'orientation' => $this->orientation,
            'scale' => $this->scale,
            'shrinkToFit' => $this->shrinkToFit,
            'background' => $this->background,
            'pageRanges' => $this->pageRanges
        ];
    }
}
