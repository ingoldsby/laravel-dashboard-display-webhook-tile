<?php

namespace Ingoldsby\DisplayWebhookTile;

use Illuminate\Support\ServiceProvider;
use Ingoldsby\DisplayWebhookTile\Commands\FetchDisplayWebhookCommand;
use Ingoldsby\DisplayWebhookTile\Components\DisplayWebhookComponent;
use Livewire\Livewire;

class DisplayWebhookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchDisplayWebhookCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-display-webhook-tiles'),
        ], 'dashboard-display-webhook-tiles');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-display-webhook-tiles');

        Livewire::component('display-webhook-tile', DisplayWebhookComponent::class);
        
    }
}
