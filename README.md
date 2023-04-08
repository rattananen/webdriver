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

See [examples.md](examples.md).

## Know issues

 - Firefox find element for shadow root doesn't implement yet (geckodriver 0.32.2)
 - Firefox  doesn't implement accessibility endpoints (computed role, computed label) for element  yet (geckodriver 0.32.2)
 - Firefox create new session is slow (geckodriver 0.32.2)
 - GoogleChrome return alert message `{Alert text : ` in unhandle alert reponse when alert without message argument (ChromeDriver 106.0.5249.61)
 - GoogleChrome duration in scroll action does wrong behevior. It's waiting time for return response instead of time for scrolling. (ChromeDriver 106.0.5249.61)

## Contributing

See [CONTRIBUTING.md](.github/CONTRIBUTING.md).