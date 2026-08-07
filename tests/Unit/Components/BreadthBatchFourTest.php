<?php

use Illuminate\Support\Facades\Blade;

/** Display, the fourth breadth batch. */
it('marks a decorative image as decoration rather than leaving it unnamed', function () {
    // An image with no alt is announced by its filename; alt="" is skipped.
    // Only the caller knows which is meant, so it has to say.
    $html = Blade::render('<x-aura::image src="/pattern.svg" decorative />');

    expect($html)
        ->toContain('alt=""')
        ->toContain('aria-hidden="true"');
});

it('renders an image caption as a real figcaption', function () {
    $html = Blade::render('<x-aura::image src="/a.jpg" alt="A chart" caption="Revenue by month" />');

    expect($html)
        ->toContain('<figure')
        ->toContain('<figcaption')
        ->toContain('alt="A chart"');
});

it('gives a price one plain sentence instead of styled fragments', function () {
    // "€" as a superscript and "/mo" as small print read as
    // "euro sign twelve slash m o".
    $html = Blade::render('<x-aura::price :amount="12" currency="€" period="month" :was="19" />');

    expect($html)
        ->toContain('aura-visually-hidden')
        ->toContain('was €19')
        ->toContain('per month')
        ->toContain('aria-hidden="true"');
});

it('formats a price without decimals when it has none', function () {
    expect(Blade::render('<x-aura::price :amount="12" />'))->toContain('>12<');
    expect(Blade::render('<x-aura::price :amount="12.5" />'))->toContain('12.50');
});

it('formats a price the way the reader’s locale writes numbers', function () {
    // This was hardcoded to 1.234,56 — simply the wrong number to an American
    // reader, in a package that ships to both.
    expect(Blade::render('<x-aura::price :amount="1234.5" locale="en_US" />'))->toContain('1,234.50');
    expect(Blade::render('<x-aura::price :amount="1234.5" locale="it_IT" />'))->toContain('1.234,50');
});

it('writes the usage state into the name, not only the colour', function () {
    $normal = Blade::render('<x-aura::usage-meter :used="10" :limit="100" label="Storage" unit="GB" />');
    $danger = Blade::render('<x-aura::usage-meter :used="95" :limit="100" label="Storage" unit="GB" />');

    expect($normal)
        ->toContain('role="progressbar"')
        ->toContain('aria-valuenow="10"')
        ->not->toContain('almost at the limit');

    expect($danger)
        ->toContain('almost at the limit')
        ->toContain('aria-valuenow="95"');
});

it('never lets the usage bar run past its own track', function () {
    $html = Blade::render('<x-aura::usage-meter :used="500" :limit="100" />');

    expect($html)->toContain('width: 100%');
});

it('reports a toggle button as pressed rather than as a plain button', function () {
    $html = Blade::render('<x-aura::toggle-button label="Pin" icon="star">Pin</x-aura::toggle-button>');

    expect($html)
        ->toContain('aria-pressed')
        ->toContain('<button');
});

it('gives an activity time a machine-readable date when one is supplied', function () {
    $html = Blade::render('<x-aura::activity-row actor="Ada" time="2 hours ago" datetime="2026-08-07T09:00:00Z">shipped v3</x-aura::activity-row>');

    expect($html)
        ->toContain('<time')
        ->toContain('datetime="2026-08-07T09:00:00Z"')
        ->toContain('<li');
});

it('announces the selection count from the action bar', function () {
    // The bar arrives without warning; a screen-reader user has no other way
    // to know a set of controls just appeared.
    $html = Blade::render('<x-aura::action-bar :count="3">x</x-aura::action-bar>');

    expect($html)
        ->toContain('role="status"')
        ->toContain('aria-live="polite"')
        ->toContain('3 selected');
});

it('puts the final figure in the ticker markup rather than counting into a live region', function () {
    // Counting up inside a live region would read out a stream of meaningless
    // numbers. The value is correct with no JavaScript at all.
    $html = Blade::render('<x-aura::ticker :value="1250" suffix="+" label="Tests" />');

    expect($html)
        ->toContain('1,250')
        ->toContain('aria-label="Tests: 1,250+"')
        ->toContain('prefers-reduced-motion: reduce')
        ->not->toContain('aria-live');
});

it('never hides revealed content from assistive technology', function () {
    // Only opacity and transform: the element stays in the accessibility tree
    // the whole time, and with reduced motion it is simply there.
    $html = Blade::render('<x-aura::reveal>content</x-aura::reveal>');

    expect($html)
        ->toContain('prefers-reduced-motion: reduce')
        ->toContain('opacity')
        ->not->toContain('display:none')
        ->not->toContain('x-cloak');
});

it('says the service state in words as well as in colour', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::status-tiles label="Systems">
            <x-aura::status-tiles.tile name="API" status="degraded" />
        </x-aura::status-tiles>
    BLADE);

    expect($html)
        ->toContain('aria-label="Systems"')
        ->toContain('Degraded')
        ->toContain('<ul')
        ->toContain('<li');
});

it('falls back to unknown for a state it has no colour for', function () {
    $html = Blade::render('<x-aura::status-tiles><x-aura::status-tiles.tile name="API" status="on fire" /></x-aura::status-tiles>');

    expect($html)
        ->toContain('Unknown')
        ->not->toContain('status-tile-on fire');
});

it('counts in the reader’s locale, not in one we picked', function () {
    expect(Blade::render('<x-aura::ticker :value="1250" locale="en_US" />'))->toContain('1,250');
    expect(Blade::render('<x-aura::ticker :value="1250" locale="it_IT" />'))->toContain('1.250');
});