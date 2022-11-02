<?php

namespace Rattananen\Webdriver\Drivers;

use Rattananen\Webdriver\DriverAbstract;
use Rattananen\Webdriver\Capability\Capabilities;
use Rattananen\Webdriver\Capability\Capability;
use Rattananen\Webdriver\Entity\TimeoutsConfiguration;


/** 
 * @final 
 */
class GoogleChrome extends DriverAbstract
{
    public static function getDefaultCapabilities(): Capabilities
    {
        $caps = new Capabilities();
        $caps->alwaysMatch = new Capability();
        $caps->alwaysMatch->browserName = 'chrome';
        $caps->alwaysMatch->timeouts = new TimeoutsConfiguration();
        $caps->alwaysMatch->extraOptions['goog:chromeOptions'] = [
            'args' => [
                // auto debug port
                //'--remote-debugging-port=0',

                // disable undesired features
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
                
                //'--disable-gpu-sandbox',
                '--metrics-recording-only',
                '--no-first-run',
                '--safebrowsing-disable-auto-update',

                // password settings
                '--password-store=basic',
                '--use-mock-keychain', // osX only
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
        return $caps;
    }
}
