<?php

namespace Rattananen\Webdriver\Input\Actions;

use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\Types\Origin;
use Rattananen\Webdriver\Input\ActionInterface;

/**
 * scrolling is perform in asynchronously!
*/
class Scroll implements ActionInterface
{

    /**
     * @param int $x offsetX
     * @param int $y offsetY
     * @param int|null $duration scrolling animation time in ms
     */
    public function __construct(
        public int $deltaX,
        public int $deltaY,
        public Origin|Element|null $origin = null,
        public ?int $duration = null,
        public int $x = 0,
        public int $y = 0

    ) {
    }

    public function getType(): string
    {
        return 'scroll';
    }

    public function jsonSerialize(): mixed
    {
        $out = [
            'type' => $this->getType(),
            'x' => $this->x,
            'y' => $this->y,
            'deltaX' => $this->deltaX,
            'deltaY' => $this->deltaY
        ];

        if (isset($this->origin)) {
            $out['origin'] = $this->origin;
        }
        if (isset($this->duration)) {
            $out['duration'] = $this->duration;
        }
        return $out;
    }
}
