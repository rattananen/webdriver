<?php
require(__DIR__ . '/../../vendor/autoload.php');
ini_set('display_errors', 1);

use Rattananen\Webdriver\LocalEnds\GoogleChrome;

$driver = new GoogleChrome();
$session = $driver->newSession();
$session->window->rect(0, 0, 1600, 900);
$url = 'http://localhost:8877/alert.html';

$session->navigateTo($url);

$elem = $session->find('.desc');

print "\nok\n";
