<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use LuongoLabs\LaravelAus\Dates\FinancialYear;

test('a financial year is named by the year it ends in', function (string $date, int $endYear, string $label, string $shortLabel) {
    $year = FinancialYear::fromDate(new DateTimeImmutable($date));

    expect($year->endYear)->toBe($endYear)
        ->and($year->label())->toBe($label)
        ->and($year->shortLabel())->toBe($shortLabel)
        ->and((string) $year)->toBe($label);
})->with([
    'last moment of June' => ['2026-06-30 23:59:59.999999', 2026, 'FY2025-26', 'FY26'],
    'first moment of July' => ['2026-07-01 00:00:00', 2027, 'FY2026-27', 'FY27'],
    'new year\'s day' => ['2027-01-01 12:00:00', 2027, 'FY2026-27', 'FY27'],
    'turn of the century' => ['1999-08-15', 2000, 'FY1999-00', 'FY00'],
]);

test('the financial year is judged in the date\'s own timezone', function () {
    // 1 July 08:00 in Sydney is still 30 June in UTC.
    $sydney = new DateTimeImmutable('2026-07-01 08:00:00', new DateTimeZone('Australia/Sydney'));

    expect(FinancialYear::fromDate($sydney)->endYear)->toBe(2027)
        ->and(FinancialYear::fromDate($sydney->setTimezone(new DateTimeZone('UTC')))->endYear)->toBe(2026);
});

test('a financial year runs from midnight on 1 July to the end of 30 June', function () {
    $year = new FinancialYear(2027);

    expect($year->start('Australia/Sydney')->format('Y-m-d H:i:s.u e'))->toBe('2026-07-01 00:00:00.000000 Australia/Sydney')
        ->and($year->end('Australia/Sydney')->format('Y-m-d H:i:s.u e'))->toBe('2027-06-30 23:59:59.999999 Australia/Sydney')
        ->and($year->contains(new DateTimeImmutable('2026-07-01')))->toBeTrue()
        ->and($year->contains(new DateTimeImmutable('2027-06-30')))->toBeTrue()
        ->and($year->contains(new DateTimeImmutable('2026-06-30')))->toBeFalse()
        ->and($year->contains(new DateTimeImmutable('2027-07-01')))->toBeFalse()
        ->and($year->previous()->label())->toBe('FY2025-26')
        ->and($year->next()->label())->toBe('FY2027-28');
});

test('the current financial year follows the clock', function () {
    CarbonImmutable::setTestNow('2026-06-30 15:00:00 UTC');

    // 15:00 UTC on 30 June is already 1 July in Sydney.
    expect(FinancialYear::current('UTC')->endYear)->toBe(2026)
        ->and(FinancialYear::current('Australia/Sydney')->endYear)->toBe(2027);

    CarbonImmutable::setTestNow();
});

test('carbon dates know their financial year', function () {
    expect(Carbon::parse('2026-10-17')->financialYear()->label())->toBe('FY2026-27')
        ->and(CarbonImmutable::parse('2026-06-30')->financialYear()->label())->toBe('FY2025-26');
});

test('immutable dates return a new start and end of their financial year', function () {
    $date = CarbonImmutable::parse('2026-10-17 09:30:00', 'Australia/Sydney');

    expect($date->startOfFinancialYear()->format('Y-m-d H:i:s.u e'))->toBe('2026-07-01 00:00:00.000000 Australia/Sydney')
        ->and($date->endOfFinancialYear()->format('Y-m-d H:i:s.u e'))->toBe('2027-06-30 23:59:59.999999 Australia/Sydney')
        ->and($date->format('Y-m-d H:i:s'))->toBe('2026-10-17 09:30:00');
});

test('mutable dates move to the start and end of their financial year like other carbon startOf methods', function () {
    $date = Carbon::parse('2027-03-02 18:00:00');

    $date->startOfFinancialYear();
    expect($date->format('Y-m-d H:i:s'))->toBe('2026-07-01 00:00:00');

    $date->endOfFinancialYear();
    expect($date->format('Y-m-d H:i:s.u'))->toBe('2027-06-30 23:59:59.999999');
});
