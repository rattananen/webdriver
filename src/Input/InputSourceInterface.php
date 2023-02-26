<?php

namespace Rattananen\Webdriver\Input;

use Rattananen\Webdriver\Input\ActionInterface;


interface InputSourceInterface extends \JsonSerializable
{
    public function getType(): string;

    public function getId(): string;

    /**
     * @return ActionInterface[]
     */
    public function getActions(): array;

    public function addAction(ActionInterface ...$actions): void;
}
