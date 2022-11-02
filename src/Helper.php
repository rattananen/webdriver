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

    /**
     * @param array<int> $codes
    */
    public static function assertStatusCode(ResponseInterface $response, array $codes): void
    {
        if (in_array($response->getStatusCode(), $codes)) {
            return;
        }
        
        throw new WebdriverException(sprintf("%s %s", $response->getStatusCode(), $response->getReasonPhrase()));
    }
}
