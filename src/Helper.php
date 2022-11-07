<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Exception\WebdriverException;
use Psr\Http\Message\ResponseInterface;

/** 
 * @final 
 */
class Helper
{
    public static function decodeJsonResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    public static function assertStatusCode(ResponseInterface $response,  int ...$codes): void
    {
        if (in_array($response->getStatusCode(), $codes)) {
            return;
        }
        
        throw new WebdriverException(sprintf("HTTP code=%s, %s", $response->getStatusCode(), $response->getReasonPhrase()));
    }
}
