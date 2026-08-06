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
        ->toContain('role="menuitem"')
        ->toContain('role="separator"');

    // aria-haspopup and aria-expanded are put on the caller's own trigger
    // element, not on the wrapper div: the wrapper has no role, and neither
    // attribute is allowed on a role-less element, so it announced nothing.
    expect($html)
        ->toContain("setAttribute('aria-haspopup', 'menu')")
        ->toContain("setAttribute('aria-expanded'");
});

it('marks command-palette dialog with role and aria-modal', function () {
    $html = Blade::render('<x-aura::command-palette />');

    expect($html)
        ->toContain('role="dialog"')
        ->toContain('aria-modal="true"');
});

/**
 * These nine were found by running every component through a real browser with
 * axe-core on 2026-08-06. The PHP suite was green throughout: it never looked
 * at accessible names.
 */
it('names each OTP box and the group around them', function () {
    $html = Blade::render('<x-aura::otp label="Verification code" :length="4" />');

    expect($html)
        ->toContain('role="group"')
        ->toContain('aria-label="Digit 1 of 4"')
        ->toContain('aria-label="Digit 4 of 4"')
        ->toContain('autocomplete="one-time-code"');
});

it('ties the slider label to the range input', function () {
    $html = Blade::render('<x-aura::slider label="Volume" />');

    expect($html)->toMatch('/<label[^>]+for="(aura-slider-[^"]+)"[\s\S]+id="\1"/');
});

it('names a slider that has no visible label', function () {
    expect(Blade::render('<x-aura::slider />'))->toContain('aria-label="Value"');
});

it('names the FAB, which never has visible text', function () {
    expect(Blade::render('<x-aura::fab />'))->toContain('aria-label="Add"');
    expect(Blade::render('<x-aura::fab label="New order" />'))->toContain('aria-label="New order"');
});

it('makes the swap a button so a keyboard can reach it', function () {
    $html = Blade::render('<x-aura::swap label="Dark mode"><x-slot:on>on</x-slot:on><x-slot:off>off</x-slot:off></x-aura::swap>');

    expect($html)
        ->toContain('<button')
        ->toContain('role="switch"')
        ->toContain('aria-label="Dark mode"');
});

it('names both progress bars', function () {
    expect(Blade::render('<x-aura::progress :value="40" />'))->toContain('aria-label="Progress"');
    expect(Blade::render('<x-aura::radial-progress :value="40" />'))->toContain('aria-label="Progress"');
});

it('names the rows-per-page select and translates its label', function () {
    $paginator = new Illuminate\Pagination\LengthAwarePaginator(range(1, 10), 137, 10, 1, ['path' => '']);
    $html = Blade::render('<x-aura::pagination :paginator="$p" />', ['p' => $paginator]);

    expect($html)
        ->toContain('Rows per page')
        ->toMatch('/<label for="(aura-per-page-[^"]+)"[\s\S]+<select id="\1"/');
});

it('gives the date and time pickers a role that allows aria-expanded', function () {
    expect(Blade::render('<x-aura::date-picker />'))->toContain('role="combobox"');
    expect(Blade::render('<x-aura::time-picker />'))->toContain('role="combobox"');
});

it('names the editor content area', function () {
    expect(Blade::render('<x-aura::editor />'))->toContain('aria-label="Editor content"');

    $labelled = Blade::render('<x-aura::editor label="Body" />');
    expect($labelled)->toMatch('/id="(aura-editor-[^"]+)-label"[\s\S]+aria-labelledby="\1-label"/');
});
