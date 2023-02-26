<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Exception\WebdriverException;
use Psr\Http\Message\ResponseInterface;

/** 
 * @final 
 */
class Helper
{
    private function __construct()
    {
    }

    public static function decodeJsonResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    public static function assertStatusCode(ResponseInterface $response,  int ...$codes): void
    {
        if (in_array($response->getStatusCode(), $codes)) {
            return;
        }

        $data = json_decode($response->getBody()->getContents(), true);

        throw new WebdriverException(sprintf("HTTP code=%s, %s", $response->getStatusCode(), $data['value']['message']));
    }

    public static function assertAndGetValue(ResponseInterface $response,  int ...$codes): mixed
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if (!in_array($response->getStatusCode(), $codes)) {
            throw new WebdriverException(sprintf("HTTP code=%s, %s", $response->getStatusCode(), $data['value']['message']));
        }

        return $data['value'];
    }
}
