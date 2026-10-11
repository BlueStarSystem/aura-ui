<?php

use BlueStarSystem\AuraUI\Support\VatNumber;

/**
 * Greece is GR in ISO 3166 but EL in VAT numbers, and EL is what VIES and every
 * Greek invoice use. Knowing only GR, the class read "EL123456789" as an
 * unprefixed Italian number and rejected every correctly written Greek VAT.
 */
it('accepts a Greek VAT number with the EL prefix it is written with', function () {
    expect(VatNumber::isValid('EL123456789'))->toBeTrue();
    expect(VatNumber::split('EL 123456789'))->toBe(['EL', '123456789']);
});

it('still checks the Greek format', function () {
    expect(VatNumber::isValid('EL12345678'))->toBeFalse();
});
