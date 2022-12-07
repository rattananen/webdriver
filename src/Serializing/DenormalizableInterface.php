<?php

namespace Rattananen\Webdriver\Serialize;

interface DenormalizableInterface
{
    public static function fromArray(array $data): static;
}