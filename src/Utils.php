<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Exception\WebdriverException;
use Rattananen\Webdriver\Exception\UnhandleAlertException;
use Rattananen\Webdriver\Exception\WebdriverExceptionInterface;
use Rattananen\Webdriver\Types\ErrorCode;
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

        throw static::createWebdriverException($response->getStatusCode(), json_decode($response->getBody()->getContents(), true)['value']);
    }

    public static function getStatusOkValue(ResponseInterface $response): mixed
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() != 200) {
            throw static::createWebdriverException($response->getStatusCode(), $data['value']);
        }

        return $data['value'];
    }

    public static function createWebdriverException(int $httpStatus, array $value): WebdriverExceptionInterface
    {
        $errorCode = ErrorCode::from($value['error']);
        if ($errorCode == ErrorCode::UnexpectedAlertOpen) {
            return new UnhandleAlertException(
                $value['message'],
                $httpStatus,
                $errorCode,
                $value['stacktrace'],
                ($value['data']['text'] == '{Alert text : ') ? null : $value['data']['text'] //chrome106.0.5249.119 bug when create any alert without message argument
            );
        }
        return new WebdriverException(
            $value['message'],
            $httpStatus,
            $errorCode,
            $value['stacktrace']
        );
    }
}
