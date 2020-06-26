<?php

namespace Ingoldsby\DisplayWebhookTile\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Ingoldsby\DisplayWebhookTile\DisplayWebhookStore;
use \Spatie\WebhookClient\Models\WebhookCall;

class FetchDisplayWebhookCommand extends Command
{
    protected $signature = 'dashboard:fetch-display-webhook {configurationName=default}';

    protected $description = 'Fetch Webhook';

    public function handle()
    {
    	$configurationName = $this->argument('configurationName');

    	$configuration = config("dashboard.tiles.webhook.configurations.{$configurationName}");

    	if (is_null($configuration)) {
            $this->error("There is no configuration named `{$configurationName}`");

            return -1;
        }

        $this->info('Fetching Webhook ...');

        $webhook = WebhookCall::latest()->first();

		$store['value'] = self::returnValueFromOffset($webhook, $configuration);		
        $store['created_at'] = $webhook->payload['created_at'];
  
        DisplayWebhookStore::make($configurationName)->setWebhook($store);

        $this->info('All done!');
    }

	private function returnCollection(WebhookCall $webhook, $config) : collection
	{
		if (is_array($webhook->$config)) {
			return collect($webhook->$config);
		}
		
		return collect(json_decode($webhook->$config));
	}

	private function returnValueFromOffset(WebhookCall $webhook, $configuration)
	{
		$collect = self::returnCollection($webhook, $configuration['column']);

		if (isset($configuration['offset'])) {
			return $collect[$configuration['value']][$configuration['offset']];
		}
		
		return $collect[$configuration['value']];
	}

}