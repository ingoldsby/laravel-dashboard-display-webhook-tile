<?php

namespace Ingoldsby\DisplayWebhookTile;

use Spatie\Dashboard\Models\Tile;

class DisplayWebhookStore
{
    private Tile $tile;

    public static function make(string $configurationName)
    {
        return new static($configurationName);
    }

    public function __construct(string $configurationName)
    {
        $this->tile = Tile::firstOrCreateForName("webhook_{$configurationName}");
    }

    public function setWebhook($info) : self
    {
        $this->tile->putData('webhook', $info);

        return $this;
    }

    public function getWebhook()
    {
        return $this->tile->getData('webhook') ?? [];
    }

}
