<?php

namespace Jkk\Webdriver\Drivers;

use Jkk\Webdriver\DriverAbstract;
use Jkk\Webdriver\Capability\Capabilities;
use Jkk\Webdriver\Capability\Capability;

/** @final */
class GoogleChrome extends DriverAbstract
{
    public static function getDefaultCapabilities(): Capabilities
    {
        $caps = new Capabilities();
        $caps->alwaysMatch = new Capability();
        $caps->alwaysMatch->browserName = 'chrome';
        $caps->alwaysMatch->extraOptions['goog:chromeOptions'] = [
            'args' => [
                // auto debug port
                '--remote-debugging-port=0',

                // disable undesired features
                '--disable-background-networking',
                '--disable-background-timer-throttling',
                '--disable-client-side-phishing-detection',
                '--disable-hang-monitor',
                '--disable-popup-blocking',
                '--disable-prompt-on-repost',
                '--disable-sync',
                '--disable-translate',
                '--disable-features=ChromeWhatsNewUI',
                '--metrics-recording-only',
                '--no-first-run',
                '--safebrowsing-disable-auto-update',

                // automation mode
                '--enable-automation',

                // password settings
                '--password-store=basic',
                '--use-mock-keychain', // osX only
                '--headless',
                '--disable-gpu',
                '--font-render-hinting=none',
                '--hide-scrollbars',
                '--mute-audio',
                '--no-sandbox',
                '--ignore-certificate-errors'
                //'--user-data-dir='
            ]
        ];
        return $caps;
        // return  [
        //     'capabilities' => [
        //         'alwaysMatch' => [
        //             'browserName' => 'chrome',
        //             'goog:chromeOptions' => [
        //                 'args' => [
        //                     // auto debug port
        //                     '--remote-debugging-port=0',

        //                     // disable undesired features
        //                     '--disable-background-networking',
        //                     '--disable-background-timer-throttling',
        //                     '--disable-client-side-phishing-detection',
        //                     '--disable-hang-monitor',
        //                     '--disable-popup-blocking',
        //                     '--disable-prompt-on-repost',
        //                     '--disable-sync',
        //                     '--disable-translate',
        //                     '--disable-features=ChromeWhatsNewUI',
        //                     '--metrics-recording-only',
        //                     '--no-first-run',
        //                     '--safebrowsing-disable-auto-update',

        //                     // automation mode
        //                     '--enable-automation',

        //                     // password settings
        //                     '--password-store=basic',
        //                     '--use-mock-keychain', // osX only
        //                     '--headless',
        //                     '--disable-gpu',
        //                     '--font-render-hinting=none',
        //                     '--hide-scrollbars',
        //                     '--mute-audio',
        //                     '--no-sandbox',
        //                     '--ignore-certificate-errors'
        //                     //'--user-data-dir='
        //                 ]
        //             ]
        //         ]

        //     ]
        // ];
    }
}
