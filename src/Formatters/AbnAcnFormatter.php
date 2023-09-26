<?php

namespace LuongoLabs\LaravelAus\Formatters;

class AbnAcnFormatter
{
    /**
     * Format an ABN as per the ATO's guidelines.
     *
     * XX XXX XXX XXX
     *
     * @param  string  $input The ABN to format, this should be 11 digits long.
     * @param  string  $separator The separator to use when formatting the ABN.
     *
     * @throws \LuongoLabs\LaravelAus\Exceptions\InvalidInputException
     */
    public static function formatAbn(string $input, string $separator = ' '): string
    {
        if (strlen($input) !== 11) {
            throw new \LuongoLabs\LaravelAus\Exceptions\InvalidInputException('ABN must be 11 digits long');
        }

        return substr($input, 0, 2).$separator.substr($input, 2, 3).$separator.substr($input, 5, 3).$separator.substr($input, 8, 3);
    }

    /**
     * Format an ACN as per the ASIC's guidelines.
     *
     * XXX XXX XXX
     *
     * @param  string  $input The ACN to format, this should be 9 digits long.
     * @param  string  $separator The separator to use when formatting the ACN.
     *
     * @throws \LuongoLabs\LaravelAus\Exceptions\InvalidInputException
     */
    public static function formatAcn(string $input, string $separator = ' '): string
    {
        if (strlen($input) !== 9) {
            throw new \LuongoLabs\LaravelAus\Exceptions\InvalidInputException('ACN must be 9 digits long');
        }

        return substr($input, 0, 3).$separator.substr($input, 3, 3).$separator.substr($input, 6, 3);
    }
}
