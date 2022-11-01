<?php

namespace Rattananen\Webdriver;

use Psr\Http\Message\ResponseInterface;

/** 
 * @final 
 */
class Helper
{
    public static function decodeJsonResponse(ResponseInterface $res): array
    {
        return json_decode($res->getBody()->getContents(), true);
    }

    public static function assertResponseCode(ResponseInterface $res, array $codes): void
    {
        if (in_array($res->getStatusCode(), $codes)) {
            return;
        }
        
        throw new \InvalidArgumentException(sprintf("%s %s", $res->getStatusCode(), $res->getReasonPhrase()));
    }
}
