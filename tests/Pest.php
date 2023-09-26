<?php

use Illuminate\Contracts\Validation\ValidationRule;
use LuongoLabs\LaravelAus\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

// From: https://freek.dev/2415-how-to-test-laravels-invokable-rules
expect()->extend('toPassWith', function (mixed $value) {
    $rule = $this->value;

    if (! $rule instanceof ValidationRule) {
        throw new Exception('Value is not an validation rule');
    }

    $passed = true;

    try {
        $fail = function () use (&$passed) {
            $passed = false;
        };

        $rule->validate('attribute', $value, $fail);
    } catch (RuntimeException $e) {
        // This should be fine to assume a failed validation.
        // This would likely be a failed translation.
        $passed = false;
    }

    expect($passed)->toBeTrue();
});

expect()->extend('toFailWith', function (mixed $value) {
    $rule = $this->value;

    if (! $rule instanceof ValidationRule) {
        throw new Exception('Value is not an validation rule');
    }

    $passed = true;

    try {
        $fail = function () use (&$passed) {
            $passed = false;
        };

        $rule->validate('attribute', $value, $fail);
    } catch (RuntimeException $e) {
        // This should be fine to assume a failed validation.
        // This would likely be a failed translation.
        $passed = false;
    }

    expect($passed)->toBeFalse();
});
