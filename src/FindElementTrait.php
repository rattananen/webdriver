<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\LocatorStrategy\LocatorStrategyInterface;

trait FindElementTrait
{

    abstract public function getBasePath(): string;

    abstract public function getDriver(): LocalEndInterface;

    public function findElement(LocatorStrategyInterface $locator): ?Element
    { 
        $res = $this->getDriver()->getClient()->post($this->getBasePath() . '/element', ['body' => json_encode($locator)]);

        Helper::assertStatusCode($res, 200, 404);

        if ($res->getStatusCode() == 404) {
            return null;
        }

        $elem = Helper::decodeJsonResponse($res)['value'];

        return new Element($this->driver, $this->sessionId, current($elem));
    }

    /**
     * @return Element[]
     */
    public function findElements(LocatorStrategyInterface $locator): array
    {
        $res = $this->getDriver()->getClient()->post($this->getBasePath() . '/elements', ['body' => json_encode($locator)]);

        Helper::assertStatusCode($res, 200);

        $data = Helper::decodeJsonResponse($res);

        $out = [];

        foreach ($data['value'] as $elem) {
            $out[] = new Element($this->driver, $this->sessionId, current($elem));
        }

        return $out;
    }
}