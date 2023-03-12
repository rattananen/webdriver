<?php

namespace Rattananen\Webdriver\Exception;

use Rattananen\Webdriver\Types\ErrorCode;

trait WebdriverExceptionTrait
{
    private int $httpStatus;
    private ErrorCode $errorCode;
    private string $stacktrace;

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getErrorCode(): ErrorCode
    {
        return $this->errorCode;
    }

    public function getStacktrace(): string
    {
        return $this->stacktrace;
    }
}
