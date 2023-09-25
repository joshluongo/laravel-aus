<?php

test('does the acn validator pass with a valid acn?', function () {
    $rule = new \LaravelAus\LaravelAus\Rules\Acn();
    // Check the B P Australia.
    expect($rule)->toPassWith('004 085 616');
});

test('does the acn validator fail with a invalid acn?', function () {
    $rule = new \LaravelAus\LaravelAus\Rules\Acn();
    expect($rule)->toFailWith('004 085 617');
});

test('is the generated acn valid?', function () {
    $acn = $this->faker->acn();
    $rule = new \LaravelAus\LaravelAus\Rules\Acn();
    expect($rule)->toPassWith($acn);
});
