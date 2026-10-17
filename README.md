# Laravel Aus 🦘

A small collection to classes to assist with making Laravel applications for the Australian market.

## Installation

You can install the package via composer:

```bash
composer require joshluongo/laravel-aus
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="aus-translations"
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

### Financial years

Australian financial years run from 1 July to 30 June and are named by the year they end in. A date's financial year is judged in its own timezone.

```php
use Carbon\CarbonImmutable;
use LuongoLabs\LaravelAus\Dates\FinancialYear;

$date = CarbonImmutable::parse('2026-10-17', 'Australia/Sydney');

$date->financialYear();          // FinancialYear for FY2026-27
$date->financialYear()->label(); // "FY2026-27"
$date->financialYear()->shortLabel(); // "FY27"
$date->startOfFinancialYear();   // 2026-07-01 00:00:00
$date->endOfFinancialYear();     // 2027-06-30 23:59:59.999999

FinancialYear::current('Australia/Sydney');
FinancialYear::fromDate(new DateTimeImmutable('2026-06-30'))->endYear; // 2026
(new FinancialYear(2027))->start('Australia/Sydney');                    // 2026-07-01 00:00:00
(new FinancialYear(2027))->contains($date);                              // true
```

The `financialYear()`, `startOfFinancialYear()` and `endOfFinancialYear()` macros are registered on `Carbon` and `CarbonImmutable` by the service provider. Like Carbon's own `startOf…` methods, the start and end methods change a mutable `Carbon` in place and return a new instance from `CarbonImmutable`.

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
