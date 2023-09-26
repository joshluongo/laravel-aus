<?php

namespace LuongoLabs\LaravelAus\Fakers;

use LuongoLabs\LaravelAus\Formatters\AbnAcnFormatter;

class AbnAcnProvider extends \Faker\Provider\Base
{
    /**
     * Generate a random Australian Business Number (ABN).
     *
     * The last 9 digits are a valid ACN.
     *
     * This follows format set out at https://abr.business.gov.au/Help/AbnFormat
     *
     * @param  bool  $formatted Whether to return the ABN in a formatted way.
     * @param  string  $separator The separator to use when formatting the ABN.
     */
    public function abn(bool $formatted = false, string $separator = ' '): string
    {
        // Generate an ACN.
        $acn = $this->acn(formatted: false);
        $abn = '00'.$acn;

        $weights = [10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19];

        // Calculate the weighted sum of the digits
        $sum = 0;
        foreach (str_split($abn) as $key => $digit) {
            $sum += intval($digit) * $weights[$key];
        }

        $number = ((89 - ($sum % 89)) + 10).$acn;

        if ($formatted) {
            $number = AbnAcnFormatter::formatAbn($number, $separator);
        }

        return $number;
    }

    /**
     * Generate a random Australian Company Number (ACN).
     *
     * This follows format set out at https://asic.gov.au/for-business/registering-a-company/steps-to-register-a-company/australian-company-numbers/australian-company-number-digit-check/
     */
    public function acn(bool $formatted = false, string $separator = ' '): string
    {
        // Generate 8 random digits.
        $random = $this->numerify('########');

        $weights = [8, 7, 6, 5, 4, 3, 2, 1];

        // Calculate the weighted sum of the digits
        $sum = 0;
        foreach (str_split($random) as $key => $digit) {
            $sum += intval($digit) * $weights[$key];
        }

        $number = $random.((10 - ($sum % 10)) % 10);

        if ($formatted) {
            $number = AbnAcnFormatter::formatAcn($number, $separator);
        }

        return $number;

    }
}
