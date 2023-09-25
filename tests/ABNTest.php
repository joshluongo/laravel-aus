<?php

test('does the abn validator pass with a valid abn?', function () {
    $rule = new \LaravelAus\LaravelAus\Rules\Abn();
    // Check the ATO ABN.
    expect($rule)->toPassWith('51 824 753 556');
});

test('does the abn validator fail with a invalid abn?', function () {
    $rule = new \LaravelAus\LaravelAus\Rules\Abn();
    expect($rule)->toFailWith('12 345 678 901');
});

test('is the generated abn valid?', function () {
    $abn = $this->faker->abn();
    $rule = new \LaravelAus\LaravelAus\Rules\Abn();
    expect($rule)->toPassWith($abn);
});
