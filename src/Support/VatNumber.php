<?php

declare(strict_types=1);

namespace BlueStarSystem\AuraUI\Support;

/**
 * European VAT numbers, checked as far as arithmetic can check them.
 *
 * Two different jobs, often confused. The **format** is fixed per country and
 * can be checked offline; several countries also publish a **checksum**, which
 * catches typos. Neither says the number belongs to a real, active business —
 * only VIES can answer that, and it needs a network call this class
 * deliberately does not make. Use this to reject what is certainly wrong before
 * anyone waits on a remote lookup.
 *
 * The Italian checksum is included in full because it is the one BSS
 * applications need every day: eleven digits, Luhn over the first ten.
 *
 * It lives in the free package on purpose. It is arithmetic with no interface,
 * useful to anyone with an invoice to check, and putting it here lets the
 * Filament package reach it without asking for a second licence. What is paid
 * for is the field that uses it.
 */
final class VatNumber
{
    /** Format per country: the length and shape the number must have. */
    private const PATTERNS = [
        'AT' => '/^U[0-9]{8}$/',
        'BE' => '/^0[0-9]{9}$/',
        'BG' => '/^[0-9]{9,10}$/',
        'CY' => '/^[0-9]{8}[A-Z]$/',
        'CZ' => '/^[0-9]{8,10}$/',
        'DE' => '/^[0-9]{9}$/',
        'DK' => '/^[0-9]{8}$/',
        'EE' => '/^[0-9]{9}$/',
        'ES' => '/^[A-Z0-9][0-9]{7}[A-Z0-9]$/',
        'FI' => '/^[0-9]{8}$/',
        'FR' => '/^[A-Z0-9]{2}[0-9]{9}$/',
        'GR' => '/^[0-9]{9}$/',
        'HR' => '/^[0-9]{11}$/',
        'HU' => '/^[0-9]{8}$/',
        'IE' => '/^([0-9]{7}[A-Z]{1,2}|[0-9][A-Z][0-9]{5}[A-Z])$/',
        'IT' => '/^[0-9]{11}$/',
        'LT' => '/^([0-9]{9}|[0-9]{12})$/',
        'LU' => '/^[0-9]{8}$/',
        'LV' => '/^[0-9]{11}$/',
        'MT' => '/^[0-9]{8}$/',
        'NL' => '/^[0-9]{9}B[0-9]{2}$/',
        'PL' => '/^[0-9]{10}$/',
        'PT' => '/^[0-9]{9}$/',
        'RO' => '/^[0-9]{2,10}$/',
        'SE' => '/^[0-9]{12}$/',
        'SI' => '/^[0-9]{8}$/',
        'SK' => '/^[0-9]{10}$/',
    ];

    public static function normalise(string $vat): string
    {
        return strtoupper(preg_replace('/[^0-9A-Za-z]/', '', $vat) ?? '');
    }

    /**
     * Split a number into its country prefix and the rest. A number typed
     * without a prefix is assumed to be from $assume.
     *
     * @return array{0: string, 1: string}
     */
    public static function split(string $vat, string $assume = 'IT'): array
    {
        $normalised = self::normalise($vat);

        if (preg_match('/^([A-Z]{2})(.+)$/', $normalised, $found) === 1 && isset(self::PATTERNS[$found[1]])) {
            return [$found[1], $found[2]];
        }

        return [strtoupper($assume), $normalised];
    }

    public static function isValid(string $vat, string $assume = 'IT'): bool
    {
        [$country, $number] = self::split($vat, $assume);

        if (! isset(self::PATTERNS[$country]) || preg_match(self::PATTERNS[$country], $number) !== 1) {
            return false;
        }

        // Only where a checksum is published and unambiguous. A country without
        // one passes on format alone rather than on a guess.
        return match ($country) {
            'IT' => self::italianChecksum($number),
            default => true,
        };
    }

    /**
     * Partita IVA: eleven digits, the last one a check digit over the first
     * ten — odd positions summed as they are, even positions doubled with the
     * two halves of anything over nine added together.
     */
    private static function italianChecksum(string $number): bool
    {
        if (preg_match('/^[0-9]{11}$/', $number) !== 1) {
            return false;
        }

        $sum = 0;

        for ($position = 0; $position < 10; $position++) {
            $digit = (int) $number[$position];

            if ($position % 2 === 0) {
                $sum += $digit;

                continue;
            }

            $doubled = $digit * 2;
            $sum += $doubled > 9 ? $doubled - 9 : $doubled;
        }

        return (10 - $sum % 10) % 10 === (int) $number[10];
    }

    /** @return list<string> */
    public static function countries(): array
    {
        return array_keys(self::PATTERNS);
    }
}
