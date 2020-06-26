<?php

namespace Ingoldsby\DisplayWebhookTile\Components;

use Ingoldsby\DisplayWebhookTile\DisplayWebhookStore;
use Livewire\Component;

class DisplayWebhookComponent extends Component
{
    /** @var string */
    public $position;

    /** @var string|null */
    public $title;

    /** @var string */
    public $configurationName;

    public function mount(string $position, ?string $title = null, string $configurationName = 'default')
    {
        $this->position = $position;

        $this->title = $title;

        $this->configurationName = $configurationName;
    }

    public function render()
    {
        return view('dashboard-display-webhook-tiles::tile', [
            'webhook' => DisplayWebhookStore::make($this->configurationName)->getWebhook(),
            'refreshIntervalInSeconds' => config('dashboard.tiles.webhook.refresh_interval_in_seconds') ?? 60,
        ]);
    }
}