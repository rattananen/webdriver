<?php

namespace Rattananen\Webdriver\LocalEnds;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\LocalEndConstructTrait;
use Rattananen\Webdriver\LocalEndTrait;
use Rattananen\Webdriver\Capability\Capabilities;
use Rattananen\Webdriver\Capability\Capability;
use Rattananen\Webdriver\Entity\TimeoutsConfiguration;

/** 
 * @final 
 */
class GoogleChrome implements LocalEndInterface
{
    use LocalEndConstructTrait, LocalEndTrait;

    public static function getDefaultCapabilities(): Capabilities
    {
      
        $always = new Capability();
        $always->browserName = 'chrome';
        $always->timeouts = new TimeoutsConfiguration();
        $always->acceptInsecureCerts = true;
        $always->strictFileInteractability = false;
        $always->extendOptions['goog:chromeOptions'] = [
            'args' => [
                //'--remote-debugging-port=0',

                '--disable-background-networking',
                '--disable-background-timer-throttling',
                '--disable-client-side-phishing-detection',
                '--disable-hang-monitor',
                '--disable-popup-blocking',
                '--disable-prompt-on-repost',
                '--disable-sync',
                '--disable-translate',
                '--disable-extensions',
                '--disable-features=ChromeWhatsNewUI',

                '--disable-gpu-sandbox',
                '--metrics-recording-only',
                '--no-first-run',
                '--safebrowsing-disable-auto-update',

                '--password-store=basic',
                '--use-mock-keychain',
                '--headless',
                '--disable-gpu',
                '--disable-crash-reporter',
                '--font-render-hinting=none',
                '--hide-scrollbars',
                '--mute-audio',
                '--no-sandbox',
                '--ignore-certificate-errors'
                //'--user-data-dir='
            ]
        ];

        return  new Capabilities($always);
    }
}
