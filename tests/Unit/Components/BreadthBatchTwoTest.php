<?php

use Illuminate\Support\Facades\Blade;

/** Layout and navigation, the second breadth batch. */
it('renders a real footer landmark', function () {
    $html = Blade::render('<x-aura::footer brand="Aura" copyright="© 2026">x</x-aura::footer>');

    expect($html)
        ->toContain('<footer')
        ->toContain('Aura')
        ->toContain('© 2026');
});

it('names each footer column from its own heading', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::footer>
            <x-aura::footer.column title="Product">
                <x-aura::footer.link href="/pricing">Pricing</x-aura::footer.link>
            </x-aura::footer.column>
        </x-aura::footer>
    BLADE);

    expect($html)
        ->toMatch('/aria-labelledby="(aura-footer-column-[^"]+)"[\s\S]+id="\1"/')
        ->toContain('<ul')
        ->toContain('<li');
});

it('says out loud that an external footer link opens a new tab', function () {
    $html = Blade::render('<x-aura::footer><x-aura::footer.column><x-aura::footer.link href="https://example.com" external>Docs</x-aura::footer.link></x-aura::footer.column></x-aura::footer>');

    expect($html)
        ->toContain('rel="noopener noreferrer"')
        ->toContain('aura-visually-hidden');
});

it('writes the bento column and span classes out in full', function () {
    // An interpolated grid-cols-{n} is a class Tailwind never sees whole, so no
    // rule is generated and the grid collapses to one column, silently.
    $html = Blade::render('<x-aura::bento-grid :columns="4"><x-aura::bento-cell :col-span="2">x</x-aura::bento-cell></x-aura::bento-grid>');

    expect($html)
        ->toContain('lg:grid-cols-4')
        ->toContain('sm:col-span-2')
        ->not->toContain('grid-cols-{')
        ->not->toContain('col-span-{');
});

it('offers system as a real third state in the theme controller', function () {
    $html = Blade::render('<x-aura::theme-controller />');

    expect($html)
        ->toContain('role="radiogroup"')
        ->toContain('value="system"')
        ->toContain('prefers-color-scheme: dark')
        // Following the system means following it as it changes.
        ->toContain('addEventListener');
});

it('honours a reduced-motion preference when scrolling to the top', function () {
    $html = Blade::render('<x-aura::scroll-to-top />');

    expect($html)
        ->toContain('prefers-reduced-motion: reduce')
        ->toContain('aria-label="Back to top"')
        // Focus has to follow the scroll or the keyboard is left behind.
        ->toContain('focus(');
});

it('marks the current page in the bottom navigation in words, not only colour', function () {
    $html = Blade::render('<x-aura::bottom-nav><x-aura::bottom-nav.item href="/" icon="home" label="Home" active /></x-aura::bottom-nav>');

    expect($html)
        ->toContain('<nav')
        ->toContain('aria-label="Primary"')
        ->toContain('aria-current="page"');
});

it('makes the toolbar a single tab stop with arrow keys inside', function () {
    $html = Blade::render('<x-aura::toolbar label="Format"><button>B</button><button>I</button></x-aura::toolbar>');

    expect($html)
        ->toContain('role="toolbar"')
        ->toContain('aria-label="Format"')
        ->toContain('keydown.arrow-right')
        ->toContain("setAttribute('tabindex'");
});

it('orients a vertical toolbar for assistive technology', function () {
    $html = Blade::render('<x-aura::toolbar orientation="vertical"><button>B</button></x-aura::toolbar>');

    expect($html)
        ->toContain('aria-orientation="vertical"')
        ->toContain('keydown.arrow-down');
});

it('builds the navigation menu out of disclosures rather than a menubar', function () {
    // A menubar takes the keyboard hostage and stops links behaving like
    // links; disclosures are what the authoring practices recommend for site
    // navigation.
    $html = Blade::render('<x-aura::navigation-menu><x-aura::navigation-menu.item title="Product">panel</x-aura::navigation-menu.item></x-aura::navigation-menu>');

    expect($html)
        ->toContain('<nav')
        ->not->toContain('role="menubar"')
        ->toContain('aria-expanded')
        ->toMatch('/aria-controls="(aura-nav-item-[^"]+)-panel"[\s\S]+id="\1-panel"/');
});

it('renders a plain link when a navigation item has an href', function () {
    $html = Blade::render('<x-aura::navigation-menu><x-aura::navigation-menu.item title="Pricing" href="/pricing" active /></x-aura::navigation-menu>');

    expect($html)
        ->toContain('href="/pricing"')
        ->toContain('aria-current="page"')
        ->not->toContain('aria-expanded');
});
