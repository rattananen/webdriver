<?php

namespace Rattananen\Webdriver\Serializing;

interface JsonDeserializableInterface
{
    public static function fromJson(string $json): static;
}
