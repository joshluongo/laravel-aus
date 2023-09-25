# Laravel Aus 🦘

A small collection to classes to assist with making Laravel applications for the Australian market.

## Installation

You can install the package via composer:

```bash
composer require joshluongo/laravel-aus
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="laravel-aus-lang"
```

## Usage

### Faker

```php
// Register in your test case file
$faker = \Faker\Factory::create();
$faker->addProvider(new \LaravelAus\LaravelAus\Fakers\AbnAcnProvider($faker));
$this->faker = $faker;

// Get random valid ABN/ACN
$this->faker->abn; // 12 123 456 789
$this->faker->acn; // 123 456 789
```

### Validation

```php
Validator::make($request->all(), [
    'abn' => new \LaravelAus\LaravelAus\Rules\Abn(),
    'acn' => new \LaravelAus\LaravelAus\Rules\Acn(),
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
