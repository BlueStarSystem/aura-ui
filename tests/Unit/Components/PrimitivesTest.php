<?php

use BlueStarSystem\AuraUI\Support\Contrast;
use Illuminate\Support\Facades\Blade;

it('renders every new primitive', function (string $markup, string $expected) {
    expect(Blade::render($markup))->toContain($expected);
})->with([
    'stack' => ['<x-aura::stack>a</x-aura::stack>', 'aura-stack'],
    'row' => ['<x-aura::row>a</x-aura::row>', 'aura-row'],
    'center' => ['<x-aura::center>a</x-aura::center>', 'aura-center'],
    'grid' => ['<x-aura::grid>a</x-aura::grid>', 'aura-grid'],
    'section' => ['<x-aura::section>a</x-aura::section>', '<section'],
    'spacer' => ['<x-aura::spacer />', 'aura-spacer'],
    'aspect-ratio' => ['<x-aura::aspect-ratio>a</x-aura::aspect-ratio>', 'aspect-ratio: 16/9'],
    'visually-hidden' => ['<x-aura::visually-hidden>a</x-aura::visually-hidden>', 'aura-visually-hidden'],
    'skip-link' => ['<x-aura::skip-link />', 'Skip to main content'],
    'code' => ['<x-aura::code>npm i</x-aura::code>', '<code'],
    'blockquote' => ['<x-aura::blockquote>q</x-aura::blockquote>', '<blockquote'],
    'mark' => ['<x-aura::mark>hit</x-aura::mark>', '<mark'],
    'link' => ['<x-aura::link href="/x">go</x-aura::link>', 'aura-link'],
    'prose' => ['<x-aura::prose>text</x-aura::prose>', 'aura-prose'],
]);

it('gives the grid literal responsive classes Tailwind can actually see', function () {
    // `grid-cols-{{ $n }}` compiles to nothing: Tailwind scans for literal
    // class names, so the component must map to whole strings.
    expect(Blade::render('<x-aura::grid :cols="4">a</x-aura::grid>'))
        ->toContain('sm:grid-cols-2')
        ->toContain('lg:grid-cols-4');
});

it('names a section only when it has a title to name it with', function () {
    expect(Blade::render('<x-aura::section title="Billing">a</x-aura::section>'))
        ->toContain('aria-labelledby="aura-section-billing"')
        ->toContain('id="aura-section-billing"');

    expect(Blade::render('<x-aura::section>a</x-aura::section>'))
        ->not->toContain('aria-labelledby');
});

it('keeps the section id stable across renders', function () {
    $markup = '<x-aura::section title="Billing">a</x-aura::section>';

    expect(Blade::render($markup))->toBe(Blade::render($markup));
});

it('tells a screen reader that an external link opens elsewhere', function () {
    $html = Blade::render('<x-aura::link href="https://example.com" external>Docs</x-aura::link>');

    expect($html)
        ->toContain('target="_blank"')
        ->toContain('rel="noopener noreferrer"')
        ->toContain('opens in a new tab');
});

it('does not add the new-tab affordances to an internal link', function () {
    $html = Blade::render('<x-aura::link href="/docs">Docs</x-aura::link>');

    expect($html)
        ->not->toContain('target="_blank"')
        ->not->toContain('opens in a new tab');
});

it('hides the spacer from assistive technology', function () {
    expect(Blade::render('<x-aura::spacer size="lg" />'))->toContain('aria-hidden="true"');
});

it('renders mark at readable contrast in every colour', function (string $bg, string $text) {
    expect(Contrast::ratio($bg, $text))->toBeGreaterThanOrEqual(Contrast::AA_NORMAL);
})->with([
    'warning' => ['#fef3c7', '#78350f'],
    'primary' => ['#dbeafe', '#312e81'],
    'success' => ['#d1fae5', '#064e3b'],
    'danger' => ['#fee2e2', '#7f1d1d'],
    'info' => ['#e0f2fe', '#0c4a6e'],
]);
