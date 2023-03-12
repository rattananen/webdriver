<?php

namespace Rattananen\Webdriver\Exception;

interface UnhandleAlertExceptionInterface extends WebdriverExceptionInterface
{
    public function getAlertText(): ?string;
}
