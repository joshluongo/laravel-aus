# Laravel Aus 🦘

A small collection to classes to assist with making Laravel applications for the Australian market.

## Installation

You can install the package via composer:

```bash
composer require joshluongo/laravel-aus
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="laravel-aus-translations"
```

## Usage

### Faker

```php
// Register in your seeder file
public function configure(): OrganisationFactory|static
{
    // Inject ABN and ACN providers.
    $this->faker->addProvider(new \LuongoLabs\LaravelAus\Fakers\AbnAcnProvider($this->faker));

    return $this;
}
```

### Validation

```php
Validator::make($request->all(), [
    'abn' => new \LuongoLabs\LaravelAus\Rules\Abn(),
    'acn' => new \LuongoLabs\LaravelAus\Rules\Acn(),
])->validate();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Josh Luongo](https://github.com/joshluongo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
