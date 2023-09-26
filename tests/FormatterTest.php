<?php

use LuongoLabs\LaravelAus\Formatters\AbnAcnFormatter;

test('format abn', function () {
    expect(AbnAcnFormatter::formatAbn('51824753556'))->toBe('51 824 753 556');
});

test('format acn', function () {
    expect(AbnAcnFormatter::formatAcn('004085616'))->toBe('004 085 616');
});

test('invalid abn returns null', function () {
    expect(AbnAcnFormatter::formatAbn('invalid'))->toBeNull();
});

test('invalid acn returns null', function () {
    expect(AbnAcnFormatter::formatAcn('invalid'))->toBeNull();
});
