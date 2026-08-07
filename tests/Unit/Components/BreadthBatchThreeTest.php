<?php

use Illuminate\Support\Facades\Blade;

/** Marketing, the third breadth batch. */
it('does not let the announcement banner interrupt a screen reader', function () {
    // role="alert" cuts across whatever is being read. Right for something
    // that just went wrong, wrong for a line that was there before the page
    // loaded.
    $html = Blade::render('<x-aura::announcement-banner>Aura UI 3.0 is out</x-aura::announcement-banner>');

    expect($html)
        ->not->toContain('role="alert"')
        ->toContain('role="region"')
        ->toContain('aria-label="Announcement"');
});

it('names the announcement dismiss button', function () {
    $html = Blade::render('<x-aura::announcement-banner>x</x-aura::announcement-banner>');

    expect($html)->toContain('aria-label="Dismiss announcement"');
});

it('only remembers a dismissal when given a key', function () {
    // A banner that vanishes for good after one accidental click, with no way
    // back, is worse than one that returns.
    expect(Blade::render('<x-aura::announcement-banner storage-key="v3">x</x-aura::announcement-banner>'))
        ->toContain('aura-dismissed-');

    expect(Blade::render('<x-aura::announcement-banner>x</x-aura::announcement-banner>'))
        ->toContain("key: ''");
});

it('leaves out the dismiss button when the banner is not dismissible', function () {
    $html = Blade::render('<x-aura::announcement-banner :dismissible="false">x</x-aura::announcement-banner>');

    expect($html)->not->toContain('aura-announcement-dismiss');
});

it('gives every logo its company name as alt text', function () {
    // "Who else uses this" is the whole point of the section; an empty alt
    // makes it a section about nobody.
    $html = Blade::render('<x-aura::logo-cloud title="Trusted by"><x-aura::logo-cloud.item name="Acme" src="/acme.svg" /></x-aura::logo-cloud>');

    expect($html)
        ->toContain('alt="Acme"')
        ->toMatch('/aria-labelledby="(aura-logo-cloud-[^"]+)-title"[\s\S]+id="\1-title"/');
});

it('writes the logo cloud column classes out in full', function () {
    $html = Blade::render('<x-aura::logo-cloud :columns="6"><x-aura::logo-cloud.item name="A" src="/a.svg" /></x-aura::logo-cloud>');

    expect($html)
        ->toContain('sm:grid-cols-6')
        ->not->toContain('grid-cols-{');
});

it('hides the mockup chrome from assistive technology', function () {
    // Three coloured circles and a fake address bar are scenery. Reading them
    // out delays the thing that matters.
    $html = Blade::render('<x-aura::mockup url="aura-ui.com">screenshot</x-aura::mockup>');

    expect($html)
        ->toContain('aria-hidden="true"')
        ->toContain('aura-ui.com')
        ->toContain('<figure');
});

it('renders a mockup caption as a real figcaption', function () {
    $html = Blade::render('<x-aura::mockup title="The dashboard">x</x-aura::mockup>');

    expect($html)->toContain('<figcaption');
});

it('renders the phone mockup without browser chrome', function () {
    $html = Blade::render('<x-aura::mockup variant="phone">x</x-aura::mockup>');

    expect($html)
        ->toContain('aura-mockup-phone')
        ->not->toContain('aura-mockup-chrome');
});

it('announces the team as a list so its size is known before reading it', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::team-section title="The team">
            <x-aura::team-member name="Ada Lovelace" role="Engineer" />
        </x-aura::team-section>
    BLADE);

    expect($html)
        ->toContain('<ul')
        ->toContain('<li')
        ->toMatch('/aria-labelledby="(aura-team-[^"]+)-title"[\s\S]+id="\1-title"/');
});

it('uses the member name as the photo alt text', function () {
    $html = Blade::render('<x-aura::team-member name="Ada Lovelace" avatar="/ada.jpg" />');

    expect($html)->toContain('alt="Ada Lovelace"');
});

it('names a member link group after the person it belongs to', function () {
    // Ten members otherwise give ten identical "Social links" groups with no
    // way to tell whose is whose.
    $html = Blade::render(<<<'BLADE'
        <x-aura::team-member name="Ada Lovelace">
            <x-slot:links><a href="#">GitHub</a></x-slot:links>
        </x-aura::team-member>
    BLADE);

    expect($html)->toMatch('/aria-labelledby="(aura-team-member-[^"]+)-name"[\s\S]*/');
    expect($html)->toMatch('/id="(aura-team-member-[^"]+)-name"/');
});
