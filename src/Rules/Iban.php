<?php

declare(strict_types=1);

namespace BlueStarSystem\AuraUI\Rules;

use BlueStarSystem\AuraUI\Support\Iban as IbanChecker;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * The field component draws the box; this is what decides whether what is in it
 * can be paid into. Client-side feedback is a courtesy — the answer that counts
 * is the one on the server.
 */
final class Iban implements ValidationRule
{
    /** @param list<string> $countries Restrict to these country codes, e.g. ['IT', 'DE']. */
    public function __construct(private array $countries = []) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            return;
        }

        if (! IbanChecker::isValid($value)) {
            $fail('aura-ui::validation.iban')->translate();

            return;
        }

        if ($this->countries !== [] && ! in_array(IbanChecker::country($value), $this->countries, true)) {
            $fail('aura-ui::validation.iban_country')->translate([
                'countries' => implode(', ', $this->countries),
            ]);
        }
    }
}
