<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Exception\WebdriverException;
use Psr\Http\Message\ResponseInterface;

/** 
 * @final 
 */
class Utils
{
    private function __construct()
    {
    }

    public static function decodeJsonResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    public static function assertStatusOk(ResponseInterface $response): void
    {
        if ($response->getStatusCode() == 200) {
            return;
        }

        $data = json_decode($response->getBody()->getContents(), true);

        throw new WebdriverException(sprintf("HTTP code=%s, %s", $response->getStatusCode(), $data['value']['message']));
    }

    public static function getStatusOkValue(ResponseInterface $response): mixed
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() != 200) {
            throw new WebdriverException(sprintf("HTTP code=%s, %s", $response->getStatusCode(), $data['value']['message']));
        }

        return $data['value'];
    }
}
