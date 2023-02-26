<?php
require(__DIR__ . '/../../vendor/autoload.php');
ini_set('display_errors', 1);

use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\RemoteEnds\ChromeDriver;
use Rattananen\Webdriver\Input\InputSources\Wheel;
use Rattananen\Webdriver\Input\InputSources\Pointer;
use Rattananen\Webdriver\Input\InputSources\Key;
use Rattananen\Webdriver\Types\CodePoint;


$remote = new ChromeDriver();
$remote->start();

$driver = new GoogleChrome();
$session = $driver->newSession();
$session->window->rect(0, 0, 1600, 900);
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


//$elem->click();

// sleep(3);
// $keyBoard = new Key();

// $keyBoard
//     ->pause() //wait for move
//     ->keyPress(CodePoint::Control);


// $btn = $session->find('#btn-test1');

// $mouse = new Pointer();

// $mouse
//     ->move(70, 0, $btn)
//     ->click();

// $session->performActions($keyBoard, $mouse);

// $text = $session->find('#text-long');

// $wheel = new Wheel();
// $wheel->scroll(0, 100, $text);

// $session->performActions($wheel);

sleep(5);

print "\nok\n";
