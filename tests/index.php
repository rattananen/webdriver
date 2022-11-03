<?php
require(__DIR__ . '/../vendor/autoload.php');

use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\Entity\Rectangle;
use Rattananen\Webdriver\Entity\Script;
use Rattananen\Webdriver\Entity\PrintProperties;
use Rattananen\Webdriver\LocatorStrategy\CssSelector;


$driver = new GoogleChrome('172.23.176.1:9515');

$session = $driver->newSession();

$session->window->setRect(new Rectangle(0, 0, 1600, 900));

$url = 'http://localhost:8001/';

$session->navigateTo($url);


$elem = $session->findElement(new CssSelector('.banner-slider--item .banner-slider--image'));

if (isset($elem)) {
    $session->print(null, __DIR__ . '/cap/' . bin2hex(random_bytes(8)) . '.pdf');
}

// $result = $session->execute(new Script('return [...arguments].reduce((acc, value)=> { return acc + value}, 0);', [1, 2, 3]));
// dump($result);

//$session->screenshot(__DIR__.'/cap/'.bin2hex(random_bytes(8)) . '.png');

// $i = 0;
// foreach($elems as $elem){
//     print $i++;
//     print '--';
//     $elem->screenshot('/var/www/html/sw5/var/caps/' . bin2hex(random_bytes(8)) . '.png');
// }

print "\nok";
