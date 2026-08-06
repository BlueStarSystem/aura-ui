<?php

use Illuminate\Support\Facades\Blade;

/**
 * Values interpolated into an Alpine attribute.
 *
 * Blade's {{ }} escapes an apostrophe to &#039;, which looks safe in the
 * source — but an HTML attribute is entity-decoded before Alpine ever reads
 * it, so the JS parser receives a real quote and the string literal closes.
 * Verified in a browser: `toggle('x&#039;); alert(1); (&#039;')` comes back
 * from getAttribute() as `toggle('x'); alert(1); ('')`, and new Function()
 * accepts it.
 *
 * Js::from is the fix: it emits a JavaScript escape ('), which survives
 * the HTML decode still inside the string.
 */
/**
 * Only the attributes Alpine evaluates as JavaScript, decoded the way the DOM
 * decodes them. A payload sitting in `data-value` is inert data and must not
 * fail this test — scoping it here rather than scanning the whole document is
 * the difference between a guard and a nuisance.
 */
function auraAlpineAttributes(string $html): string
{
    preg_match_all('/(?:x-[a-z-]+|@[a-z.:-]+|:[a-z-]+)="([^"]*)"/i', $html, $matches);

    return html_entity_decode(implode("\n", $matches[1]), ENT_QUOTES | ENT_HTML5);
}

it('does not let a value close the JavaScript string it sits in', function (string $markup, array $data) {
    $alpine = auraAlpineAttributes(Blade::render($markup, $data));

    // The payload closes the literal, runs a call, and reopens one.
    expect($alpine)->not->toContain("'); alert(1); ('");
})->with([
    'accordion item' => [
        '<x-aura::accordion><x-aura::accordion.item :name="$p" title="T" open>b</x-aura::accordion.item></x-aura::accordion>',
        ['p' => "x'); alert(1); ('"],
    ],
    'command palette item' => [
        '<x-aura::command-palette><x-aura::command-palette.item :value="$p">x</x-aura::command-palette.item></x-aura::command-palette>',
        ['p' => "x'); alert(1); ('"],
    ],
    'tabs' => [
        '<x-aura::tabs :tabs="$t"><x-slot:panels>x</x-slot:panels></x-aura::tabs>',
        ['t' => [['name' => "x'); alert(1); ('", 'label' => 'L']]],
    ],
    'tab panel' => [
        '<x-aura::tabs :tabs="$t"><x-slot:panels><x-aura::tabs.tab :name="$t[0][\'name\']">p</x-aura::tabs.tab></x-slot:panels></x-aura::tabs>',
        ['t' => [['name' => "x'); alert(1); ('", 'label' => 'L']]],
    ],
]);

it('still matches the value it was given', function () {
    // The guard must not break the feature it protects: a normal tab name
    // still drives the comparison Alpine evaluates.
    $html = Blade::render(
        '<x-aura::tabs :tabs="$t"><x-slot:panels>x</x-slot:panels></x-aura::tabs>',
        ['t' => [['name' => 'billing', 'label' => 'Billing']]],
    );

    expect($html)->toContain("activeTab = 'billing'");
});

/**
 * The other Alpine interpolations are numbers, booleans or values the
 * component computes itself. This pins that: if one is later swapped for a
 * prop, it fails here first.
 */
it('interpolates only values it controls elsewhere', function (string $markup, string $expected) {
    expect(Blade::render($markup))->toContain($expected);
})->with([
    'collapsible boolean' => ['<x-aura::collapsible title="T" open>x</x-aura::collapsible>', 'open: true'],
    'rating integer' => ['<x-aura::rating :value="3" />', 'rating: 3'],
    'stepper integer' => ['<x-aura::stepper :active="2"><x-aura::stepper.step label="A" /></x-aura::stepper>', 'active: 2'],
    'swap boolean' => ['<x-aura::swap active>x</x-aura::swap>', 'swapped: true'],
]);
