<?php

declare(strict_types=1);

namespace BlueStarSystem\AuraUI\Support;

/**
 * Codice fiscale: the Italian personal tax code, checked by its own algorithm.
 *
 * Sixteen characters ending in a check letter computed over the other fifteen,
 * with one table for odd positions and another for even ones — deliberately
 * different so that swapping two adjacent characters changes the result.
 *
 * A valid code is a well-formed one, not a real person's. Only the Agenzia
 * delle Entrate can say the second thing.
 */
final class FiscalCode
{
    private const ODD = [
        '0' => 1, '1' => 0, '2' => 5, '3' => 7, '4' => 9, '5' => 13, '6' => 15, '7' => 17,
        '8' => 19, '9' => 21, 'A' => 1, 'B' => 0, 'C' => 5, 'D' => 7, 'E' => 9, 'F' => 13,
        'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21, 'K' => 2, 'L' => 4, 'M' => 18, 'N' => 20,
        'O' => 11, 'P' => 3, 'Q' => 6, 'R' => 8, 'S' => 12, 'T' => 14, 'U' => 16, 'V' => 10,
        'W' => 22, 'X' => 25, 'Y' => 24, 'Z' => 23,
    ];

    private const EVEN = [
        '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7,
        '8' => 8, '9' => 9, 'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5,
        'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13,
        'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21,
        'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25,
    ];

    private const CHECK = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function normalise(string $code): string
    {
        return strtoupper(preg_replace('/[^0-9A-Za-z]/', '', $code) ?? '');
    }

    public static function isValid(string $code): bool
    {
        $normalised = self::normalise($code);

        // Letters and digits alternate in a fixed pattern: six letters, two
        // digits, a letter, two digits, a letter, three alphanumerics for the
        // town, and the check letter. Homocodes replace a digit with a letter,
        // which is why those positions accept both.
        if (preg_match('/^[A-Z]{6}[0-9LMNPQRSTUV]{2}[ABCDEHLMPRST][0-9LMNPQRSTUV]{2}[A-Z][0-9LMNPQRSTUV]{3}[A-Z]$/', $normalised) !== 1) {
            return false;
        }

        $sum = 0;

        for ($position = 0; $position < 15; $position++) {
            $character = $normalised[$position];

            // One-based positions: the first character is odd.
            $sum += $position % 2 === 0
                ? (self::ODD[$character] ?? 0)
                : (self::EVEN[$character] ?? 0);
        }

        return self::CHECK[$sum % 26] === $normalised[15];
    }
}
