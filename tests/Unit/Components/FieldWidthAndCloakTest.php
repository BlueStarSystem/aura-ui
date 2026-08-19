<?php

use Illuminate\Support\Facades\Blade;

/**
 * Two defects that were invisible from inside the package and obvious the moment
 * somebody built a real form with it.
 */

/*
 * Nine components carried `max-w-[340px]` in a class list they built themselves.
 * Five did not merge the attributes they were given, so the width could not be
 * changed from outside at all; in the other four a `max-w-none` only tied with
 * the utility already there, leaving the winner to stylesheet order. On a card
 * wider than 340px the fields sat visibly narrower than the button beneath them.
 */
it('does not hardcode a width cap on any field wrapper', function () {
    $views = glob(__DIR__.'/../../../resources/views/components/*.blade.php');

    $offenders = [];

    foreach ($views as $view) {
        if (str_contains((string) file_get_contents($view), 'max-w-[340px]')) {
            $offenders[] = basename($view);
        }
    }

    expect($offenders)->toBe([]);
});

it('hangs the field width on a custom property that an application can change', function () {
    $css = (string) file_get_contents(__DIR__.'/../../../resources/css/components/fields.css');

    expect($css)
        ->toContain('.aura-field')
        ->toContain('var(--aura-field-max-width, 340px)');
});

it('marks every field wrapper with the width hook', function (string $tag) {
    $html = Blade::render("<x-aura::{$tag} />");

    expect($html)->toContain('aura-field');
})->with(['input', 'select', 'textarea', 'number-input', 'password-input', 'iban-field', 'phone-input', 'combobox', 'range-slider']);

/*
 * Alpine removes x-cloak once it has booted; until then only a stylesheet rule
 * hides the element. The package used the attribute in twenty-five components
 * and shipped no such rule, so every application that had not written one saw
 * those components in all of their states at once — the password field showed
 * its "reveal" and its "hide" icon side by side.
 */
it('ships the rule its x-cloak components depend on', function () {
    $css = (string) file_get_contents(__DIR__.'/../../../resources/css/base/alpine.css');

    expect($css)
        ->toContain('[x-cloak]')
        ->toContain('display: none !important');
});

it('imports both stylesheets from the entry point', function () {
    $css = (string) file_get_contents(__DIR__.'/../../../resources/css/aura.css');

    expect($css)
        ->toContain('@import "./base/alpine.css";')
        ->toContain('@import "./components/fields.css";');
});

it('keeps the rules inside a layer, which a production build does not drop', function (string $file) {
    $css = (string) file_get_contents(__DIR__.'/../../../resources/css/'.$file);

    expect($css)->toMatch('/@layer\s+(base|components)\s*\{/');
})->with(['base/alpine.css', 'components/fields.css']);
