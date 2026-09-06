<?php

use Illuminate\Support\Facades\Blade;

/*
 * Reported by the TempGuard instance (2026-09-06): a consent checkbox needs
 * links inside its label, and the label prop was a plain string; and the
 * docs showed an `error` prop the component did not have.
 */

it('uses the default slot as the label so links can live in it', function () {
    $html = Blade::render('<x-aura::checkbox name="terms">I accept the <a href="/terms">Terms</a></x-aura::checkbox>');

    expect($html)
        ->toContain('aura-checkbox-label')
        ->toContain('I accept the <a href="/terms">Terms</a>');
});

it('still takes the label prop for the simple case', function () {
    $html = Blade::render('<x-aura::checkbox name="news" label="Send me news" />');

    expect($html)->toContain('Send me news');
});

it('renders no label wrapper when neither prop nor slot is given', function () {
    $html = Blade::render('<x-aura::checkbox name="bare" />');

    expect($html)->not->toContain('aura-checkbox-label');
});

it('exposes an error as aria-invalid plus an associated alert', function () {
    $html = Blade::render('<x-aura::checkbox name="terms" label="Accept" error="You must accept the terms." />');

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toMatch('/<p id="([^"]+)" role="alert"[^>]*>You must accept the terms\.<\/p>/');

    preg_match('/<p id="([^"]+)" role="alert"/', $html, $m);
    expect($html)->toMatch('/aria-describedby="[^"]*'.preg_quote($m[1], '/').'[^"]*"/');
});

it('lists both the description and the error in aria-describedby', function () {
    $html = Blade::render('<x-aura::checkbox name="terms" label="Accept" description="Read them first." error="Required." />');

    preg_match('/aria-describedby="([^"]+)"/', $html, $m);

    expect(explode(' ', $m[1]))->toHaveCount(2);
});

it('does not mark a checkbox without an error as invalid', function () {
    $html = Blade::render('<x-aura::checkbox name="terms" label="Accept" />');

    expect($html)->not->toContain('aria-invalid');
});
