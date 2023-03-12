<?php

namespace Rattananen\Webdriver\Exception;

use Rattananen\Webdriver\Types\ErrorCode;

interface WebdriverExceptionInterface extends \Throwable
{
    public function getHttpStatus(): int;

    public function getErrorCode(): ErrorCode;
    
    public function getStacktrace(): string;
}
