<?php
require(__DIR__.'/../vendor/autoload.php');

use Rattananen\Webdriver\Drivers\GoogleChrome;
use Rattananen\Webdriver\Rectangle;

$driver = new GoogleChrome();

$session = $driver->newSession();

$session->window->setRect(new Rectangle(0, 0, 1600, 900));

$url = 'http://localhost:8001/freizeitwelten/vintage/145/muetze-vintage-driver?c=31';

$session->navigateTo($url);
//var/www/html/wdev/package/webdriver/public

$session->screenshot('/var/www/html/wdev/package/webdriver/public/'.bin2hex(random_bytes(8)).'.png');

print "\nok";



