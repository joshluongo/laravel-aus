<?php

namespace LaravelAus\LaravelAus\Fakers;

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
            // Format: 00 000 000 000
            $p1 = substr($number, 0, 2);
            $p2 = substr($number, 2, 3);
            $p3 = substr($number, 5, 3);
            $p4 = substr($number, 8);
            $number = $p1.$separator.$p2.$separator.$p3.$separator.$p4;
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
            // Format: 000 000 000
            $p1 = substr($number, 0, 3);
            $p2 = substr($number, 3, 3);
            $p3 = substr($number, 6, 3);
            $number = $p1.$separator.$p2.$separator.$p3.$separator;
        }

        return $number;

    }
}
