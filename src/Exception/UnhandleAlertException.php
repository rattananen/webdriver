<?php

namespace Rattananen\Webdriver\Exception;

use Rattananen\Webdriver\Types\ErrorCode;

class UnhandleAlertException extends \Exception implements UnhandleAlertExceptionInterface
{
    use WebdriverExceptionTrait;

    public function __construct(
        string $message,
        private int $httpStatus,
        private ErrorCode $errorCode,
        private string $stacktrace,
        private ?string $alertText = null
    ) {

        parent::__construct($message);
    }

    public function getAlertText(): ?string
    {
        return $this->alertText;
    }
}
