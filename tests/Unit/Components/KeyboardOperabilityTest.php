<?php

use Illuminate\Support\Facades\Blade;

/**
 * Found by a browser check the markup tests could not do: an element that
 * responds to a click but that Tab cannot reach. A div takes no focus and
 * Enter and Space do nothing on it, so the control is pointer-only — a
 * failure of WCAG 2.1.1, Level A, inside the standard we claim.
 *
 * The swap was the first: role="switch" on a div. axe reported the missing
 * name and could not report the missing keyboard.
 */
it('makes the collapsible trigger a button so it opens without a pointer', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::collapsible>
            <x-slot:trigger>Details</x-slot:trigger>
            Body
        </x-aura::collapsible>
    BLADE);

    expect($html)
        ->toMatch('/<button[^>]+aura-collapsible-trigger/')
        ->toContain('aria-expanded')
        ->toMatch('/aria-controls="(aura-collapsible-[^"]+)"[\s\S]+id="\1"/');
});

it('makes the swap a button rather than a switch nobody can focus', function () {
    $html = Blade::render('<x-aura::swap label="Dark mode"><x-slot:on>on</x-slot:on><x-slot:off>off</x-slot:off></x-aura::swap>');

    expect($html)
        ->toContain('<button')
        ->toContain('role="switch"')
        ->not->toMatch('/<div[^>]+role="switch"/');
});
