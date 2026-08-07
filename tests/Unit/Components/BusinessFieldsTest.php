<?php

use BlueStarSystem\AuraUI\Rules\Iban as IbanRule;
use BlueStarSystem\AuraUI\Support\Iban;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

/** The fields a European business application rewrites in every project. */
it('accepts IBANs that check out', function (string $iban) {
    expect(Iban::isValid($iban))->toBeTrue();
})->with([
    'IT60X0542811101000000123456',
    'DE89370400440532013000',
    'GB29NWBK60161331926819',
    'FR1420041010050500013M02606',
    'NL91ABNA0417164300',
    'ES9121000418450200051332',
    'IT60 X054 2811 1010 0000 0123 456',
]);

it('rejects an IBAN with one character wrong', function () {
    // The whole point of the checksum: a single typo has to fail, because the
    // payment leaves either way.
    expect(Iban::isValid('IT60X0542811101000000123457'))->toBeFalse();
});

it('rejects an IBAN of the wrong length for its country', function () {
    // A checksum can agree on a number that is too short: the length is a
    // separate check, per country, and skipping it lets those through.
    expect(Iban::isValid('DE8937040044053201300'))->toBeFalse();
    expect(Iban::isValid('XX89370400440532013000'))->toBeFalse();
});

it('prints an IBAN the way a bank prints it', function () {
    expect(Iban::format('IT60X0542811101000000123456'))->toBe('IT60 X054 2811 1010 0000 0123 456');
    expect(Iban::normalise('it60 x054-2811'))->toBe('IT60X0542811');
});

it('fails validation on a bad IBAN and passes on a good one', function () {
    $bad = Validator::make(['iban' => 'IT60X0542811101000000123457'], ['iban' => new IbanRule]);
    $good = Validator::make(['iban' => 'IT60X0542811101000000123456'], ['iban' => new IbanRule]);

    expect($bad->fails())->toBeTrue();
    expect($good->fails())->toBeFalse();
});

it('can be held to a set of countries', function () {
    $rule = new IbanRule(['IT']);

    expect(Validator::make(['iban' => 'DE89370400440532013000'], ['iban' => $rule])->fails())->toBeTrue();
    expect(Validator::make(['iban' => 'IT60X0542811101000000123456'], ['iban' => $rule])->fails())->toBeFalse();
});

it('posts the IBAN without the spaces it is displayed with', function () {
    // The grouping is for reading. A payment file with spaces in it is
    // rejected by the bank.
    $html = Blade::render('<x-aura::iban-field label="IBAN" value="IT60X0542811101000000123456" />');

    expect($html)
        ->toContain('IT60 X054 2811 1010 0000 0123 456')
        ->toContain('<input type="hidden" name="iban" x-bind:value="plain"');
});

it('sends a currency amount as a machine number, not as it is written', function () {
    // "1.234,56" reaching the server is read as 1.234, and a thousand euro
    // disappear from the invoice.
    $html = Blade::render('<x-aura::currency-input label="Total" :value="1234.5" locale="it_IT" />');

    expect($html)
        ->toContain('1.234,50')
        ->toContain('x-bind:value="plain"')
        ->toContain('inputmode="decimal"');
});

it('writes the amount the way the reader writes numbers', function () {
    expect(Blade::render('<x-aura::currency-input :value="1234.5" locale="en_US" />'))->toContain('1,234.50');
    expect(Blade::render('<x-aura::currency-input :value="1234.5" locale="it_IT" />'))->toContain('1.234,50');
});

it('keeps the currency symbol out of the announcement', function () {
    // Read aloud before every amount, it is noise: the currency is already in
    // the field's description.
    $html = Blade::render('<x-aura::currency-input label="Total" currency="EUR" />');

    expect($html)->toContain('aura-currency-input-symbol')->toContain('aria-hidden="true"');
});

it('gives the dialling code a name of its own', function () {
    // A select with no label is "combo box" and nothing else.
    $html = Blade::render('<x-aura::phone-input label="Phone" />');

    expect($html)
        ->toContain('<select')
        ->toContain('aria-label="Country code"')
        ->toContain('type="tel"');
});

it('splits a number that arrives already international', function () {
    // Otherwise the prefix ends up typed twice: +39+39...
    $html = Blade::render('<x-aura::phone-input label="Phone" value="+393331234567" />');

    expect($html)
        ->toContain("prefix: '+39'")
        ->toContain("national: '3331234567'");
});

it('posts the whole telephone number, not the half that was typed', function () {
    $html = Blade::render('<x-aura::phone-input name="mobile" />');

    expect($html)->toContain('<input type="hidden" name="mobile" x-bind:value="full"');
});

it('offers a way to sign that does not need a pointer', function () {
    // Drawing a curve has no keyboard equivalent, which makes a bare signature
    // pad a 2.1.1 failure and a form some people cannot submit.
    $html = Blade::render('<x-aura::signature-pad label="Signature" />');

    expect($html)
        ->toContain('<canvas')
        ->toContain('Or type your name')
        ->toContain('role="status"')
        ->toContain('touch-action: none');
});

it('says which of the two ways produced the signature', function () {
    $html = Blade::render('<x-aura::signature-pad />');

    expect($html)
        ->toContain('Nothing signed yet')
        ->toContain('Signature drawn')
        ->toContain("'typed:'");
});
