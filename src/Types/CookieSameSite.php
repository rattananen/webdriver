<?php

namespace Rattananen\Webdriver\Types;

enum CookieSameSite: string
{
    case Lax = 'Lax';
    case Strict = 'Strict';
    case None = 'None';
}
