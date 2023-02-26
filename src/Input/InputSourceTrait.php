<?php

namespace Rattananen\Webdriver\Input;

use Rattananen\Webdriver\Input\Actions\Pause;

trait InputSourceTrait
{

    public string $id;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @var ActionInterface[]
     */
    public array $actions = [];

    /**
     * @return ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function addAction(ActionInterface ...$actions): void
    {
        $this->actions += $actions;
    }

    /**
     * @param int|null $duration time is ms.
     */
    public function pause(?int $duration = null): static
    {
        $this->actions[] = new Pause($duration);
        return $this;
    }
}
