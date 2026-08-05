<?php

use Illuminate\Support\Facades\Blade;

/**
 * These four ship in the package and in the manifest — `aura:add container`
 * works — but they had neither a docs page nor a test, so nothing proved they
 * still rendered. They were also missing from the public registry, which is
 * docs-driven, and therefore from the component count.
 */
it('renders the layout primitives', function (string $markup, string $expected) {
    expect(Blade::render($markup))->toContain($expected);
})->with([
    'aside' => ['<x-aura::aside>side</x-aura::aside>', '<aside'],
    'container' => ['<x-aura::container>body</x-aura::container>', 'aura-container'],
    'main' => ['<x-aura::main>body</x-aura::main>', '<main'],
]);

it('groups its radios in a fieldset with the label as the legend', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::radio-group label="Plan">
            <x-aura::radio name="plan" value="a" label="Alpha" />
            <x-aura::radio name="plan" value="b" label="Beta" />
        </x-aura::radio-group>
    BLADE);

    // fieldset + legend is the pattern that makes a group of radios announce
    // its own question to a screen reader; a bare <div> does not.
    expect($html)
        ->toContain('<fieldset')
        ->toContain('<legend')
        ->toContain('Plan')
        ->toContain('Alpha')
        ->toContain('Beta');

    expect(substr_count($html, 'type="radio"'))->toBe(2);
});
