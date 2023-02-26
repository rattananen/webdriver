<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Locator\LocatorInterface;
use Rattananen\Webdriver\Locator\Locators\CssSelector;
use Rattananen\Webdriver\Types\W3C;

trait FindElementTrait
{

    abstract public function getBaseUri(): string;

    abstract public function getDriver(): LocalEndInterface;

    public function findElement(LocatorInterface $locator): ?Element
    {
        $res = $this->getDriver()->getClient()->post($this->getBaseUri() . '/element', $locator);

        if ($res->getStatusCode() == 404) {
            return null;
        }

        $value = Helper::assertAndGetValue($res, 200);

        return new Element($this->driver, $this->sessionId, $value[W3C::ELEMENT_IDENTIFIER]);
    }


    /**
     * @return Element[]
     */
    public function findElements(LocatorInterface $locator): array
    {
        $res = $this->getDriver()->getClient()->post($this->getBaseUri() . '/elements', $locator);

        $value = Helper::assertAndGetValue($res, 200);

        $out = [];

        foreach ($value as $elem) {
            $out[] = new Element($this->driver, $this->sessionId, $elem[W3C::ELEMENT_IDENTIFIER]);
        }

        return $out;
    }

    /**
     * shorthand for findElement with CssSelector
     */
    public function find(string $selector): ?Element
    {
        return $this->findElement(new CssSelector($selector));
    }

    /**
     * shorthand for findElements with CssSelector
     */
    public function findAll(string $selector): array
    {
        return $this->findElements(new CssSelector($selector));
    }
}
