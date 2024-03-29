<?php

namespace Rattananen\Webdriver\Exception;

use Rattananen\Webdriver\Types\ErrorCode;

class WebdriverException extends \Exception implements WebdriverExceptionInterface
{
    use WebdriverExceptionTrait;

    public function __construct(
        string $message,
        private int $httpStatus,
        private ErrorCode $errorCode,
        private string $stacktrace,
    ) {
        parent::__construct($message);
    }
}
