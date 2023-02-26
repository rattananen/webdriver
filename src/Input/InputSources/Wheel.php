<?php

namespace Rattananen\Webdriver\Input\InputSources;

use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\Types\Origin;
use Rattananen\Webdriver\Input\InputSourceInterface;
use Rattananen\Webdriver\Input\InputSourceTrait;
use Rattananen\Webdriver\Input\Actions\Scroll;

class Wheel implements InputSourceInterface
{
    use InputSourceTrait;

    public function __construct(?string $id = null)
    {
        $this->id = $id ?? 'wheel-' . bin2hex(random_bytes(6));
    }

    public function getType(): string
    {
        return 'wheel';
    }

    public function jsonSerialize(): mixed
    {
        return  [
            'type' => $this->getType(),
            'id' => $this->id,
            'actions' => $this->actions
        ];
    }

    /**
     * Important, scrolling is perform in asynchronously!
     * 
     * @param int $x offsetX
     * @param int $y offsetY
     * @param int|null $duration waiting time in ms
     */
    public function scroll(
        int $deltaX,
        int $deltaY,
        Origin|Element|null $origin = null,
        ?int $duration = null,
        int $x = 0,
        int $y = 0
    ): static {
        $this->actions[] = new Scroll($deltaX, $deltaY, $origin, $duration, $x, $y);
        return $this;
    }
}
