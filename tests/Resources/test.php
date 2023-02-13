<?php
require(__DIR__ . '/../../vendor/autoload.php');
ini_set('display_errors', 1);
//phpinfo();

// function test(int $x){
//     return $x;
// }
// $b = test(...);

// print $b;
use Rattananen\Webdriver\LocalEnds\GoogleChrome;

$driver = new GoogleChrome();

$session = $driver->newSession();

//$session->window->rect(0, 0, 1600, 900);

//$url = 'http://localhost:8877/input.html';

//$session->navigateTo($url);

//print $session->getCurrentUrl();

//print $session->source();
//$elem = $session->find('.btn-test');
//sleep(3);
//$elem->click();

//sleep(5);
//dump($r);

//$elem->screenshotTo(__DIR__ . '/web/cap/' . bin2hex(random_bytes(8)) . '.png');
//print $elem->text();

//if (isset($elem)) {
   //$session->printTo(__DIR__ . '/web/cap/' . bin2hex(random_bytes(8)) . '.pdf');
//}

// $result = $session->execute(new Script('return [...arguments].reduce((acc, value)=> { return acc + value}, 0);', [1, 2, 3]));
// dump($result);

//$session->screenshotTo(__DIR__.'/web/cap/'.bin2hex(random_bytes(8)) . '.png');

print "\nok\n";