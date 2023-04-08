<?php

namespace Rattananen\Webdriver\LocalEnds;

use Rattananen\Webdriver\LocalEndInterface;
use Rattananen\Webdriver\LocalEndTrait;
use Rattananen\Webdriver\ClientInterface;
use Rattananen\Webdriver\Client;
use Rattananen\Webdriver\Capability\Capabilities;
use Rattananen\Webdriver\Capability\Capability;
use Rattananen\Webdriver\Entity\TimeoutsConfiguration;

/** 
 * @final 
 */
class Firefox implements LocalEndInterface
{
    use LocalEndTrait;

    private ClientInterface $client;

    private string $baseUri;

    public function __construct(
        string $host = 'localhost:4444',
        bool $testConnection = true,
        ?ClientInterface $client = null
    ) {
        $this->baseUri = 'http://' . $host;

        $this->client = $client ?? new Client();

        if ($testConnection) {
            try {
                $this->status();
            } catch (\Throwable $th) {
                throw new \RuntimeException(sprintf("Error while connect %s.", $this->baseUri), 0, $th);
            }
        }
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public static function getDefaultCapabilities(): Capabilities
    {
        $always = new Capability();
        $always->browserName = 'firefox';
        $always->timeouts = new TimeoutsConfiguration();
        $always->acceptInsecureCerts = true;
        $always->strictFileInteractability = false;
        $always->extendOptions['moz:firefoxOptions'] = [
            'args' => [
                '--headless',
                '--safe-mode'
            ],
            'prefs' => [
                'dom.ipc.processCount' => 8,
                'dom.disable_beforeunload' => true,
                'browser.search.update' => false,
                'browser.startup.couldRestoreSession.count' => -1,
                'browser.tabs.disableBackgroundZombification' => false,
                'browser.toolbars.bookmarks.visibility' => 'never',
                'browser.topsites.contile.enabled' => false,
                'browser.urlbar.suggest.searches' => false,
                'extensions.getAddons.cache.enabled' => false,
                'privacy.trackingprotection.enabled' => false,
                'datareporting.policy.dataSubmissionPolicyAccepted' => false
            ],
        ];

        return  new Capabilities($always);
    }
}
