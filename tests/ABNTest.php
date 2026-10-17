<?php

use LuongoLabs\LaravelAus\Rules\Abn;

test('does the abn validator pass with a valid abn?', function () {
    $rule = new Abn;
    // Check the ATO ABN.
    expect($rule)->toPassWith('51 824 753 556');
});

test('does the abn validator fail with a invalid abn?', function () {
    $rule = new Abn;
    expect($rule)->toFailWith('12 345 678 901');
});

test('is the generated abn valid?', function () {
    $abn = $this->faker->abn();
    $rule = new Abn;
    expect($rule)->toPassWith($abn);
});
