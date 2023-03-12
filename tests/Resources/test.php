<?php
require(__DIR__ . '/../../vendor/autoload.php');
ini_set('display_errors', 1);


use Rattananen\Webdriver\LocalEnds\GoogleChrome;


$driver = new GoogleChrome();

print "\nok\n";
