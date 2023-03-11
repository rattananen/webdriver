<?php

namespace Rattananen\Webdriver\Types;

enum UnhandledPromptBehavior: string
{
    case Dismiss = 'dismiss';
    case Accept = 'accept';
    case DismissAndNotify = 'dismiss and notify';
    case AcceptAndNotify = 'accept and notify';
    case Ignore = 'ignore';
}
