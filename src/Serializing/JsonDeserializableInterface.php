<?php

namespace Rattananen\Webdriver\Serializing;

interface JsonDeserializableInterface
{
    public static function fromJson(string $json): static;

    public static function fromArray(array $data): static;
}
