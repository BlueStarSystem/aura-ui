<?php

use Illuminate\Support\Facades\Blade;

/**
 * `away` was accepted by the component and missing from the stylesheet, so the
 * dot rendered transparent — a white ring with nothing inside, which read as a
 * clipped circle. Juri spotted it on the homepage.
 *
 * The class name was interpolated from the prop, so any value without a rule
 * failed the same silent way.
 */
it('gives every documented status a colour class and a name', function () {
    foreach (['online', 'offline', 'busy', 'away'] as $status) {
        $html = Blade::render('<x-aura::avatar name="Ada" status="'.$status.'" />');

        expect($html)
            ->toContain('aura-avatar-status-'.$status)
            ->toContain('role="img"')
            ->toContain('aria-label=');
    }
});

it('falls back rather than rendering a dot no stylesheet knows about', function () {
    $html = Blade::render('<x-aura::avatar name="Ada" status="lunching" />');

    expect($html)
        ->toContain('aura-avatar-status-offline')
        ->not->toContain('aura-avatar-status-lunching');
});

it('has a rule for every status the component will emit', function () {
    // The two halves used to disagree, and nothing said so.
    $css = file_get_contents(__DIR__.'/../../../resources/css/components/residual.css');

    foreach (['online', 'offline', 'busy', 'away'] as $status) {
        expect($css)->toContain('.aura-avatar-status-'.$status.' {');
    }
});
