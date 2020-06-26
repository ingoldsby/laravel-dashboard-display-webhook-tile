# A tile to display basic details of a webhook from a database

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ingoldsby/laravel-dashboard-display-webhook-tile.svg?style=flat-square)](https://packagist.org/packages/ingoldsby/laravel-dashboard-display-webhook-tile)
[![Total Downloads](https://img.shields.io/packagist/dt/ingoldsby/laravel-dashboard-display-webhook-tile.svg?style=flat-square)](https://packagist.org/packages/ingoldsby/laravel-dashboard-display-webhook-tile)

This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard) to display a webhook from your database.

![Screenshot](https://user-images.githubusercontent.com/26500496/85898681-13555a80-b840-11ea-9ea1-4543fd14af13.png)

## Installation

You can install the package via composer:

```bash
composer require ingoldsby/laravel-dashboard-display-webhook-tile
```

This package uses `spatie/laravel-webhook-client` as the webhook provider.

## Usage

In the `dashboard` config file, you must add this configuration in the `tiles` key. You can add a configuration in the configurations key per Webhook tile that you want to display. In this example, the webhook_calls table has been amended to capture the headers of the incoming request. Due to the formatting of the request, an offset is required (in this case, 0) to get the correct item.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'webhook' => [
            'configurations' => [
                'default' => [
                    'column' => 'headers',
                    'value' => 'x-shopify-topic',
                    'offset' => 0,
                ]
            ],
            'refresh_interval_in_seconds' => 60,
        ]
    ],
];
```

This example shows multiple configurations, with the second one named `payload`, matching the default column in the `webhook_calls` table. Note: the default column in this example does not need an offset so it is not included.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'webhook' => [
            'configurations' => [
                'default' => [
                    'column' => 'headers',
                    'value' => 'x-shopify-topic',
                    'offset' => 0,
                ],
                'payload' => [
                    'column' => 'payload',
                    'value' => 'id',
                ],
            ],
            'refresh_interval_in_seconds' => 60,
        ]
    ],
];
```

In `app\Console\Kernel.php` you should schedule the `\Ingoldsby\DisplayWebhookTile\Commands\FetchDisplayWebhookCommand` to run. You can decide the frequency of running the command.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(\Ingoldsby\DisplayWebhookTile\Commands\FetchDisplayWebhookCommand::class)->everyMinute();
}
```

To display webhook details of another configuration, simply add the name of the configuration as an arugment.

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(\Ingoldsby\DisplayWebhookTile\Commands\FetchDisplayWebhookCommand::class, ['alternate-configuration-name'])->everyMinute();
}
```

In your dashboard view you can use the tile:
* `livewire:display-webhook-tile`

```html
<x-dashboard>
    <livewire:display-webhook-tile position="a1" />
</x-dashboard>
```

To display webhook details of another configuration, pass the name of the configuration to the configuration-name prop.

```html
<x-dashboard>
    <livewire:display-webhook-tile position="a1" configuration-name="alternate-configuration-name" />
</x-dashboard>
```

The default title of the tile will be `Latest Webhook` unless you pass a string using the title prop.

```html
<x-dashboard>
    <livewire:display-webhook-tile position="a1" configuration-name="alternate-configuration-name" title="Title of tile" />
</x-dashboard>
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email instead of using the issue tracker.

## Support Spatie

I have learnt a lot from Spatie's various packages, including [Mailcoach](https://mailcoach.app), and would recommend you check them out if you want to know more.

Learn how to create a package like theirs, by watching Spatie's premium video course:

[![Laravel Package training](https://spatie.be/github/package-training.jpg)](https://laravelpackage.training)

Spatie invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support them by [buying one of their paid products](https://spatie.be/open-source/support-us).

## Credits

- [Ingoldsby](https://github.com/ingoldsby)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.