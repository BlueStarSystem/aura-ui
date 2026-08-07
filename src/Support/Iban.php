<?php

declare(strict_types=1);

namespace BlueStarSystem\AuraUI\Support;

/**
 * IBAN: check it, and print it so a human can read it back.
 *
 * The check is the one from ISO 13616 — move the first four characters to the
 * end, turn letters into numbers, and the whole thing modulo 97 must be 1. It
 * catches every single-character typo and almost every transposition, which is
 * the point: a wrong IBAN is a payment that leaves and does not arrive.
 *
 * It says nothing about whether the account exists. Nothing offline can.
 */
final class Iban
{
    /** Length is fixed per country; a valid checksum on the wrong length is still wrong. */
    private const LENGTHS = [
        'AD' => 24, 'AE' => 23, 'AL' => 28, 'AT' => 20, 'AZ' => 28, 'BA' => 20, 'BE' => 16,
        'BG' => 22, 'BH' => 22, 'BR' => 29, 'BY' => 28, 'CH' => 21, 'CR' => 22, 'CY' => 28,
        'CZ' => 24, 'DE' => 22, 'DK' => 18, 'DO' => 28, 'EE' => 20, 'EG' => 29, 'ES' => 24,
        'FI' => 18, 'FO' => 18, 'FR' => 27, 'GB' => 22, 'GE' => 22, 'GI' => 23, 'GL' => 18,
        'GR' => 27, 'GT' => 28, 'HR' => 21, 'HU' => 28, 'IE' => 22, 'IL' => 23, 'IS' => 26,
        'IT' => 27, 'JO' => 30, 'KW' => 30, 'KZ' => 20, 'LB' => 28, 'LC' => 32, 'LI' => 21,
        'LT' => 20, 'LU' => 20, 'LV' => 21, 'MC' => 27, 'MD' => 24, 'ME' => 22, 'MK' => 19,
        'MR' => 27, 'MT' => 31, 'MU' => 30, 'NL' => 18, 'NO' => 15, 'PK' => 24, 'PL' => 28,
        'PS' => 29, 'PT' => 25, 'QA' => 29, 'RO' => 24, 'RS' => 22, 'SA' => 24, 'SC' => 31,
        'SE' => 24, 'SI' => 19, 'SK' => 24, 'SM' => 27, 'TN' => 24, 'TR' => 26, 'UA' => 29,
        'VA' => 22, 'VG' => 24, 'XK' => 20,
    ];

    public static function normalise(string $iban): string
    {
        return strtoupper(preg_replace('/[^0-9A-Za-z]/', '', $iban) ?? '');
    }

    /** Groups of four, which is how every bank prints it and how people read it back. */
    public static function format(string $iban): string
    {
        return trim(chunk_split(self::normalise($iban), 4, ' '));
    }

    public static function country(string $iban): ?string
    {
        $normalised = self::normalise($iban);

        return preg_match('/^[A-Z]{2}/', $normalised, $found) === 1 ? $found[0] : null;
    }

    public static function isValid(string $iban): bool
    {
        $normalised = self::normalise($iban);

        if (preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]+$/', $normalised) !== 1) {
            return false;
        }

        $country = substr($normalised, 0, 2);

        if (! isset(self::LENGTHS[$country]) || strlen($normalised) !== self::LENGTHS[$country]) {
            return false;
        }

        return self::modulo97(substr($normalised, 4).substr($normalised, 0, 4)) === 1;
    }

    /**
     * The number is far too large for an integer, so it is reduced a piece at a
     * time — the same arithmetic, done in chunks that fit.
     */
    private static function modulo97(string $rearranged): int
    {
        $digits = '';

        foreach (str_split($rearranged) as $character) {
            $digits .= ctype_alpha($character)
                ? (string) (ord($character) - 55)
                : $character;
        }

        $remainder = 0;

        foreach (str_split($digits, 7) as $chunk) {
            $remainder = (int) ((string) $remainder.$chunk) % 97;
        }

        return $remainder;
    }
}
