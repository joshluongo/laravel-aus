<?php

namespace LuongoLabs\LaravelAus\Dates;

use Carbon\CarbonImmutable;
use DateTimeInterface;
use DateTimeZone;
use Stringable;

/**
 * An Australian financial year, which runs from 1 July to 30 June and is named by the year it ends in.
 */
final class FinancialYear implements Stringable
{
    /**
     * The month a financial year starts in.
     */
    public const START_MONTH = 7;

    /**
     * @param  int  $endYear  the calendar year the financial year ends in (FY2026-27 ends in 2027)
     */
    public function __construct(public readonly int $endYear) {}

    /**
     * Get the financial year a date falls in, judged in the date's own timezone.
     */
    public static function fromDate(DateTimeInterface $date): self
    {
        $year = (int) $date->format('Y');

        return new self((int) $date->format('n') >= self::START_MONTH ? $year + 1 : $year);
    }

    /**
     * Get the financial year it is now, optionally in a given timezone.
     */
    public static function current(DateTimeZone|string|null $timezone = null): self
    {
        return self::fromDate(CarbonImmutable::now($timezone));
    }

    /**
     * Get the calendar year the financial year starts in.
     */
    public function startYear(): int
    {
        return $this->endYear - 1;
    }

    /**
     * Get the first moment of the financial year: midnight on 1 July.
     */
    public function start(DateTimeZone|string|null $timezone = null): CarbonImmutable
    {
        return CarbonImmutable::create($this->startYear(), self::START_MONTH, 1, 0, 0, 0, $timezone);
    }

    /**
     * Get the last moment of the financial year: the end of 30 June.
     */
    public function end(DateTimeZone|string|null $timezone = null): CarbonImmutable
    {
        return $this->start($timezone)->addYear()->subMicrosecond();
    }

    /**
     * Determine whether a date falls in the financial year, judged in the date's own timezone.
     */
    public function contains(DateTimeInterface $date): bool
    {
        return self::fromDate($date)->endYear === $this->endYear;
    }

    /**
     * Get the financial year before this one.
     */
    public function previous(): self
    {
        return new self($this->endYear - 1);
    }

    /**
     * Get the financial year after this one.
     */
    public function next(): self
    {
        return new self($this->endYear + 1);
    }

    /**
     * Get the full label, e.g. "FY2026-27".
     */
    public function label(): string
    {
        return sprintf('FY%d-%02d', $this->startYear(), $this->endYear % 100);
    }

    /**
     * Get the short label, e.g. "FY27".
     */
    public function shortLabel(): string
    {
        return sprintf('FY%02d', $this->endYear % 100);
    }

    public function __toString(): string
    {
        return $this->label();
    }
}
