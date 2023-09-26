<?php

use LuongoLabs\LaravelAus\Formatters\AbnAcnFormatter;

test('format abn', function () {
    expect(AbnAcnFormatter::formatAbn('51824753556'))->toBe('51 824 753 556');
});

test('format acn', function () {
    expect(AbnAcnFormatter::formatAcn('004085616'))->toBe('004 085 616');
});

it('invalid abn raises exception', function () {
    AbnAcnFormatter::formatAbn('invalid');
})->throws(\LuongoLabs\LaravelAus\Exceptions\InvalidInputException::class);

it('invalid acn raises exception', function () {
    AbnAcnFormatter::formatAcn('invalid');
})->throws(\LuongoLabs\LaravelAus\Exceptions\InvalidInputException::class);
