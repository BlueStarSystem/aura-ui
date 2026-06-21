<?php

use Illuminate\Support\Facades\Blade;

it('links input error message via aria-describedby and marks aria-invalid', function () {
    $html = Blade::render('<x-aura::input error="Required" />');

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('aria-describedby="');

    preg_match('/aria-describedby="([^"]+)"/', $html, $describedBy);
    preg_match('/aura-input-error-text[^>]*id="([^"]+)"|id="([^"]+)"[^>]*aura-input-error-text/', $html, $errorId);

    $referenced = $describedBy[1] ?? null;
    $target = $errorId[1] ?: ($errorId[2] ?? null);

    expect($referenced)->not->toBeNull();
    expect($target)->toBe($referenced);
});

it('links input hint via aria-describedby without aria-invalid', function () {
    $html = Blade::render('<x-aura::input hint="Helpful" />');

    expect($html)
        ->toContain('aria-describedby="')
        ->not->toContain('aria-invalid');
});

it('marks select error with aria-invalid and aria-describedby', function () {
    $html = Blade::render('<x-aura::select error="Pick one" />');

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('aria-describedby="');
});

it('marks textarea error with aria-invalid and aria-describedby', function () {
    $html = Blade::render('<x-aura::textarea error="Too short" />');

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('aria-describedby="');
});

it('links floating-input error via aria-describedby', function () {
    $html = Blade::render('<x-aura::floating-input name="email" label="Email" error="Invalid" />');

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('aria-describedby="');
});

it('links checkbox description via aria-describedby', function () {
    $html = Blade::render('<x-aura::checkbox label="Terms" description="Read the terms" />');

    expect($html)->toContain('aria-describedby="');
});

it('links radio description via aria-describedby', function () {
    $html = Blade::render('<x-aura::radio label="Yes" description="Choose this" />');

    expect($html)->toContain('aria-describedby="');
});

it('exposes toasts container as a polite live region', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('role="region"')
        ->toContain('aria-live="polite"');
});

it('marks modal as an accessible dialog with labelled title', function () {
    $html = Blade::render('<x-aura::modal title="Confirm">Body</x-aura::modal>');

    expect($html)
        ->toContain('role="dialog"')
        ->toContain('aria-modal="true"')
        ->toContain('aria-labelledby="');

    preg_match('/aria-labelledby="([^"]+)"/', $html, $labelledBy);
    preg_match('/aura-modal-title[^>]*id="([^"]+)"|id="([^"]+)"[^>]*aura-modal-title/', $html, $titleId);

    $referenced = $labelledBy[1] ?? null;
    $target = ($titleId[1] ?? '') ?: ($titleId[2] ?? null);

    expect($target)->toBe($referenced);
});

it('marks drawer as an accessible dialog', function () {
    $html = Blade::render('<x-aura::drawer title="Settings">Body</x-aura::drawer>');

    expect($html)
        ->toContain('role="dialog"')
        ->toContain('aria-modal="true"');
});

it('marks dropdown as a menu with proper trigger semantics', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::dropdown>
            <x-slot:trigger><button>Menu</button></x-slot:trigger>
            <x-aura::dropdown.item>Edit</x-aura::dropdown.item>
            <x-aura::dropdown.separator />
        </x-aura::dropdown>
    BLADE);

    expect($html)
        ->toContain('role="menu"')
        ->toContain('aria-haspopup="menu"')
        ->toContain('role="menuitem"')
        ->toContain('role="separator"');
});

it('marks command-palette dialog with role and aria-modal', function () {
    $html = Blade::render('<x-aura::command-palette />');

    expect($html)
        ->toContain('role="dialog"')
        ->toContain('aria-modal="true"');
});
