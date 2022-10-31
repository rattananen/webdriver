<?php

namespace Jkk\Webdriver;

use Psr\Http\Message\ResponseInterface;

/** @final */
class Helper
{
    public static function decodeJsonResponse(ResponseInterface $res): array
    {
        return json_decode($res->getBody()->getContents(), true);
    }
}
