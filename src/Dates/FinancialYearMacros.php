<?php

namespace LuongoLabs\LaravelAus\Dates;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Closure;

/**
 * Adds Australian financial year methods to Carbon and CarbonImmutable.
 *
 * Like Carbon's own startOf / endOf methods, the start and end methods modify a mutable Carbon in place and
 * return a new instance from a CarbonImmutable. Each keeps the date's timezone.
 */
final class FinancialYearMacros
{
    /**
     * Register the macros on both Carbon classes.
     */
    public static function register(): void
    {
        foreach (self::macros() as $name => $macro) {
            Carbon::macro($name, $macro);
            CarbonImmutable::macro($name, $macro);
        }
    }

    /**
     * Carbon binds each macro to the date it is called on, which static analysis cannot see.
     *
     * @return array<string, Closure>
     */
    private static function macros(): array
    {
        return [
            'financialYear' => function (): FinancialYear {
                return FinancialYear::fromDate($this); // @phpstan-ignore variable.undefined
            },
            'startOfFinancialYear' => function (): CarbonInterface {
                return FinancialYearMacros::startOf($this); // @phpstan-ignore variable.undefined
            },
            'endOfFinancialYear' => function (): CarbonInterface {
                return FinancialYearMacros::endOf($this); // @phpstan-ignore variable.undefined
            },
        ];
    }

    /**
     * Move a date to midnight on 1 July of its financial year.
     */
    public static function startOf(CarbonInterface $date): CarbonInterface
    {
        return $date->setDate(FinancialYear::fromDate($date)->startYear(), FinancialYear::START_MONTH, 1)->startOfDay();
    }

    /**
     * Move a date to the end of 30 June of its financial year.
     */
    public static function endOf(CarbonInterface $date): CarbonInterface
    {
        return $date->setDate(FinancialYear::fromDate($date)->endYear, FinancialYear::START_MONTH - 1, 30)->endOfDay();
    }
}
