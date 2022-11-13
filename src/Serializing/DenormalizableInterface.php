<?php

namespace Rattananen\Webdriver\Serializing;

interface DenormalizableInterface
{
    public static function fromArray(array $data): static;
}