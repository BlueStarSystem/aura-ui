<?php

use Illuminate\Support\Facades\Blade;

function renderDropdown(string $attributes = ''): string
{
    return Blade::render(<<<BLADE
        <x-aura::dropdown {$attributes}>
            <x-slot:trigger><button type="button">Open</button></x-slot:trigger>
            <x-aura::dropdown.item>Edit</x-aura::dropdown.item>
        </x-aura::dropdown>
    BLADE);
}

it('anchors the menu below and to the left by default', function () {
    $html = renderDropdown();

    expect($html)
        ->toContain('top-[calc(100%+4px)]')
        ->toContain('left-0')
        ->toContain('origin-top-left');
});

it('anchors the menu to the right edge for bottom-end', function () {
    $html = renderDropdown('position="bottom-end"');

    expect($html)
        ->toContain('right-0')
        ->toContain('origin-top-right')
        ->not->toContain('left-0');
});

it('opens the menu upwards for top-start and top-end', function () {
    expect(renderDropdown('position="top-start"'))
        ->toContain('bottom-[calc(100%+4px)]')
        ->toContain('origin-bottom-left');

    expect(renderDropdown('position="top-end"'))
        ->toContain('bottom-[calc(100%+4px)]')
        ->toContain('right-0')
        ->toContain('origin-bottom-right');
});

it('falls back to bottom-start for an unknown position', function () {
    expect(renderDropdown('position="sideways"'))
        ->toContain('left-0')
        ->toContain('origin-top-left');
});

/**
 * The wrapper used to write its own class="" and then dump $attributes after
 * it, so a class passed by the caller became a second class attribute, which
 * the HTML parser discards. There was no way to restyle the menu from outside.
 */
it('merges a caller class into the wrapper instead of emitting two class attributes', function () {
    $html = renderDropdown('class="ml-auto"');

    expect($html)->toContain('class="aura-dropdown relative inline-block ml-auto"');
});
