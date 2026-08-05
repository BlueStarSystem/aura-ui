<?php

use Illuminate\Support\Facades\Blade;

/**
 * From the BeautyFlow instance's proposal, docs/proposals/2026-08-05: an error
 * that is drawn but not associated leaves a screen-reader user hearing the
 * label and nothing about the field being wrong. aria-invalid and
 * aria-describedby were already there; role="alert", a stable id and the merge
 * with an incoming aria-describedby were not.
 */
it('associates the error message with the field it belongs to', function () {
    $html = Blade::render('<x-aura::input name="email" label="Email" error="That address is not valid." />');

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('aria-describedby="email-description"')
        ->toContain('id="email-description"')
        ->toContain('role="alert"');
});

it('announces the error without waiting for the user to come back to the field', function () {
    // A Livewire submit inserts the message into a page the user is already
    // on; without role="alert" nothing is spoken until they navigate to it.
    expect(Blade::render('<x-aura::input name="vat" error="Required" />'))
        ->toContain('role="alert"');

    expect(Blade::render('<x-aura::input name="vat" hint="Nine digits" />'))
        ->not->toContain('role="alert"');
});

it('keeps the field id stable across renders', function () {
    $markup = '<x-aura::input name="email" label="Email" error="Nope" />';

    expect(Blade::render($markup))->toBe(Blade::render($markup));
});

it('derives an id from the name when none is given', function () {
    expect(Blade::render('<x-aura::input name="contact[email]" label="Email" />'))
        ->toContain('id="contact-email"');
});

it('keeps an explicit id rather than inventing one', function () {
    expect(Blade::render('<x-aura::input id="billing-email" name="email" />'))
        ->toContain('id="billing-email"');
});

it('merges the error id into an aria-describedby the application passed', function () {
    $html = Blade::render('<x-aura::input name="email" aria-describedby="email-help" error="Nope" />');

    // One attribute carrying both ids — not two attributes, of which a browser
    // keeps the first and drops the application's help text.
    expect(substr_count($html, 'aria-describedby='))->toBe(1);
    expect($html)->toContain('aria-describedby="email-help email-description"');
});

it('leaves an application aria-describedby alone when there is nothing to add', function () {
    $html = Blade::render('<x-aura::input name="email" aria-describedby="email-help" />');

    expect(substr_count($html, 'aria-describedby='))->toBe(1);
    expect($html)->toContain('aria-describedby="email-help"');
});

it('points the label at the field', function () {
    $html = Blade::render('<x-aura::input name="email" label="Email address" />');

    expect($html)
        ->toContain('for="email"')
        ->toContain('id="email"');
});

it('gives every error-carrying control the same treatment', function (string $markup, string $idPrefix) {
    $html = Blade::render($markup);

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('role="alert"')
        ->toContain('aria-describedby="'.$idPrefix.'-description"')
        ->toContain('id="'.$idPrefix.'-description"');
})->with([
    'input' => ['<x-aura::input name="a" error="Nope" />', 'a'],
    'textarea' => ['<x-aura::textarea name="b" error="Nope" />', 'b'],
    'select' => ['<x-aura::select name="c" error="Nope" />', 'c'],
    'floating-input' => ['<x-aura::floating-input name="d" label="D" error="Nope" />', 'd'],
]);

it('keeps checkbox and radio description ids stable across renders', function (string $markup) {
    expect(Blade::render($markup))->toBe(Blade::render($markup));
})->with([
    '<x-aura::checkbox name="terms" label="Accept" description="Required to continue" />',
    '<x-aura::radio name="plan" value="a" label="Alpha" description="The cheap one" />',
]);
