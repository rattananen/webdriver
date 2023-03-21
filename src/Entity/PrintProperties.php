<?php

namespace Rattananen\Webdriver\Entity;

use Rattananen\Webdriver\Types\PrintOrientation;

class PrintProperties implements \JsonSerializable
{
    public float $pageWidth = 21.59; //cm
    public float $pageHeight  = 27.94;

    public float $marginTop = 1.0;
    public float $marginRight = 1.0;
    public float $marginBottom = 1.0;
    public float $marginLeft = 1.0;

    public PrintOrientation $orientation = PrintOrientation::portrait;
    public float $scale = 1.0;
    public bool $shrinkToFit = true;
    public bool $background = true;
    
    private PageRanges $pageRanges;

    public function pageRanges(): PageRanges
    {
        return $this->pageRanges ??= new PageRanges();
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
            'pageRanges' => $this->pageRanges ?? [] //pageRanges must be array
        ];
    }
}
