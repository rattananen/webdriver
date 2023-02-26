<?php

namespace Rattananen\Webdriver;

interface RemoteEndInterface
{
    public function start(): void;

    public function stop(): void;
}
