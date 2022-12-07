<?php

namespace Rattananen\Webdriver;

use Rattananen\Webdriver\Locator\LocatorInterface;

trait FindElementTrait
{

    abstract public function getBasePath(): string;

    abstract public function getDriver(): LocalEndInterface;

    public function findElement(LocatorInterface $locator): ?Element
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
    public function findElements(LocatorInterface $locator): array
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