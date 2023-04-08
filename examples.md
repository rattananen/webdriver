# Examples

- Assume PHP server at port 8877 by use `tests/Resources/web` as public.
- ChormeDriver running at port 9515.
- Autoload class is include already.

## 1. Wait and Capture Element

```php
use Rattananen\Webdriver\LocalEnds\GoogleChrome;

$driver = new GoogleChrome('localhost:9515');
$session = $driver->newSession(); //create new session aka open new window.

$session->window->rect(0, 0, 1600, 900); //set browser position to 0,0 (top-left of monitor) and window width, height to 1600x900px.

$session->timeouts(implicit:1000); //set timeout for find element to 1000ms. We could also set by capability at new session.

$session->navigateTo('http://localhost:8877/js.html');

$img = $session->find('.common-img'); //use css selector to find element this function will wait element appear in DOM until timeout that we set.

if(is_null($img)){
    throw new \RuntimeException('Image not found.');
}

$captureFile = $img->screenshotTo('element.png'); //screenshot is always PNG.

$screenFile = $session->screenshotTo('php://temp'); //capture whole current screen to temp file.

$pdf = $session->printTo('screen.pdf');
```
📙 No need to close any resource because we did when object has no reference ([destructor](https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.destructor)). But you could also call `$session->delete()` for release resource if you want.

📙 Normally web driver is long live process no need to start them by ourself, but we also provide function for start them temporary.

```php
use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\RemoteEnds\ChromeDriver;

$remote = new ChromeDriver();
$remote->start(); //process will stop after object has no reference.

$driver = new GoogleChrome();
...
```

## 2. Select files for upload

```php
use Rattananen\Webdriver\Entity\FileList;
use Rattananen\Webdriver\LocalEnds\GoogleChrome;

$driver = new GoogleChrome();
$session = $driver->newSession();

$session->navigateTo('http://localhost:8877/file.html');

$files = new FileList();
$files[] = 'file1.png';
$files[] = 'file2.png';

//or

$files = realpath('file1.png')."\n".realpath('file2.png');

$session->find('#file-input')?->sendKeys($files);
```

## 3. Emulate mouse and key board

```php
use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\Input\InputSources\Pointer;
use Rattananen\Webdriver\Input\InputSources\Key;
use Rattananen\Webdriver\Types\PointerType;
use Rattananen\Webdriver\Types\PointerButton;

$driver = new GoogleChrome();
$session = $driver->newSession();
$session->navigateTo('http://localhost:8877/input.html');

$keyboard = new Key(); //create keyboard input source
$keyboard
    ->pause() //wait for mouse move
    ->keyDown(CodePoint::Alt)
    ->keyUp(CodePoint::Alt);

$btn = $session->find('#btn-test1');

$mouse = new Pointer(null, PointerType::mouse); //create mouse input source
$mouse
    ->move(70, 0, $btn) //move on x‐axis 70px start from middle of #btn-test1 button.
    ->down(PointerButton::primary)
    ->up(PointerButton::primary);

$session->performActions($keyboard, $mouse); //result will be move mouse on x‐axis 70px start from middle of #btn-test1 button then hold Alt+left click then release both mouse and key.
```
📙 Reason why we send pause action before Alt key down is we want key down and mousedown dispatch in same tick. [More info](https://www.w3.org/TR/webdriver/#example-11).

📙 There is bunch of predefine input behavior in `Rattananen\Webdriver\Input\InputBuilder`.

## 4. Alert handle

```php
use Rattananen\Webdriver\LocalEnds\GoogleChrome;
use Rattananen\Webdriver\Exception\UnhandleAlertExceptionInterface;

$driver = new GoogleChrome();
$session = $driver->newSession();
$session->navigateTo('http://localhost:8877/alert.html');

$session->find('#alert-btn')?->click(); //alert appear.

try{
    $bbtn = $session->find('#confirm-btn'); //if there is any prompt while handle request WebDriver will result error by default.
}catch(UnhandleAlertExceptionInterface $e){ //we provide special exception for this case
    print $e->getAlertText();
    $session->dismissAlert();
}
```