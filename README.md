# Rattananen WebDriver

This library is implementation for  [W3C WebDriver](https://www.w3.org/TR/webdriver/) protocol. Currently, support only ChromeDriver but there is plan to support other in future.

## Features

- Use modern/forgotten programming techniques to make easier for development application by this library.
- IDE friendly.
- Implement all [W3C WebDriver Endpoints](https://www.w3.org/TR/webdriver/#endpoints) mean you can control browser with fully protocol's capacity.

## Requirement

- PHP 8.1+
- Google Chrome 106+
- [ChromeDriver](https://chromedriver.chromium.org/downloads) version that compactible with Google Chrome

## Installation

Best way is install via composer

```bash
composer require rattananen/webdriver
```
⚠️ This package has optional dependencies. They will missing when you  install composer with `--no-dev` parameter. You can use `composer require package/missing` to install them if need.

## Examples

- Assume PHP server at port 8877 by use `tests/Resources/web` as public.
- ChormeDriver running at port 9515.
- Autoload class is include already.

### 1. Wait and Capture Element

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

### 2. Select files for upload

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

### 3. Emulate mouse and key board

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
    ->move(70, 0, $btn) //move in x‐axis 70px start from middle of #btn-test1 button.
    ->down(PointerButton::primary)
    ->up(PointerButton::primary);

$session->performActions($keyboard, $mouse); //result will be move mouse in x‐axis 70px start from middle of #btn-test1 button then hold Alt+left click then release both mouse and key.
```
📙 Reason why we send pause action before Alt key down is we want key down and mousedown dispatch in same tick. [More info](https://www.w3.org/TR/webdriver/#example-11).

## Todos

Some ideas will implement in future.

- Add input soruce builder for create variant input actions.
- Improve Rattananen\Webdriver\Entity\PrintProperties make easier define page ranges.
- Improve Capability for local end. I felt there is something could improve here.
- Create separate API for implement more complex logic e.g. switch window, current API is design follow endpoints that Ok but still need more work to switch window.
- Add Firefox, Edge driver. I want to add Safari as well but I can't install it.

## Contributing

Any issue, idea, suggestion or pull request are welcome.

### Bug reporting

When create a bug reporting issue, try to give us many detail as possible. It should include follow.

- PHP version
- Browser / Driver version
- OS
- Reproduce procedure. 
- Stack trace/Error message

### Pull request for feature/fixed

It will have more efficiency if We create a issue for discuss before coding.

### Coding

- Formating similar to current code format (I use VS Code + PHP Intelephense to format code).
- Express intent to your code. [More Info](https://en.wikipedia.org/wiki/Self-documenting_code).
- Test your code.