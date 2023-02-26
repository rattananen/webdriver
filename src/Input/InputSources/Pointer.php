<?php

namespace Rattananen\Webdriver\Input\InputSources;

use Rattananen\Webdriver\Input\InputSourceInterface;
use Rattananen\Webdriver\Input\InputSourceTrait;
use Rattananen\Webdriver\Input\Actions\PointerDown;
use Rattananen\Webdriver\Input\Actions\PointerUp;
use Rattananen\Webdriver\Input\Actions\PointerMove;
use Rattananen\Webdriver\Types\PointerButton;
use Rattananen\Webdriver\Types\Origin;
use Rattananen\Webdriver\Types\PointerType;
use Rattananen\Webdriver\Element;

class Pointer implements InputSourceInterface
{
    use InputSourceTrait;

    public function __construct(
        ?string $id = null,
        public PointerType $pointerType = PointerType::mouse
    ) {
        $this->id = $id ?? 'pointer-' . bin2hex(random_bytes(6));
    }

    public function getType(): string
    {
        return 'pointer';
    }

    public function jsonSerialize(): mixed
    {
        return  [
            'type' => $this->getType(),
            'id' => $this->id,
            'parameters' => ['pointerType' => $this->pointerType],
            'actions' => $this->actions
        ];
    }

    public function down(PointerButton $btn = PointerButton::primary): static
    {
        $this->actions[] = new PointerDown($btn);
        return $this;
    }

    public function up(PointerButton $btn = PointerButton::primary): static
    {
        $this->actions[] = new PointerUp($btn);
        return $this;
    }

    public function move(int $x, int $y, Origin|Element|null $origin = null, ?int $duration = null, ): static
    {
        $this->actions[] = new PointerMove($x,  $y,  $origin, $duration);
        return $this;
    }

    public function click(PointerButton $btn = PointerButton::primary): static
    {
        $this->actions[] = new PointerDown($btn);
        $this->actions[] = new PointerUp($btn);

        return $this;
    }
}
