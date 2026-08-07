<?php

use BlueStarSystem\AuraUI\Support\QrCode;
use Illuminate\Support\Facades\Blade;

/** The four WireKit had and we did not. */
it('announces a button group as a group with a name', function () {
    // Three buttons that touch are still three unrelated controls unless
    // something says they belong together.
    $html = Blade::render('<x-aura::button-group label="Text alignment"><x-aura::button>Left</x-aura::button></x-aura::button-group>');

    expect($html)
        ->toContain('role="group"')
        ->toContain('aria-label="Text alignment"')
        ->toContain('aura-button-group');
});

it('stacks a vertical group without losing the joining rules', function () {
    $html = Blade::render('<x-aura::button-group orientation="vertical"><x-aura::button>One</x-aura::button></x-aura::button-group>');

    expect($html)
        ->toContain('aura-button-group-vertical')
        ->toContain('flex-col');
});

it('gives a QR code the thing it encodes as its name', function () {
    // A QR code is a picture of a string. Unnamed, it is nothing at all to a
    // screen reader or to anyone whose camera will not focus.
    $html = Blade::render('<x-aura::qr-code value="https://aura-ui.com" />');

    expect($html)->toContain('role="img"')->toContain('aria-label="https://aura-ui.com"');

    if (QrCode::available()) {
        expect($html)->toContain('<svg');
    }
});

it('shows the value as a link only when it is one', function () {
    $link = Blade::render('<x-aura::qr-code value="https://aura-ui.com" show-value />');
    $wifi = Blade::render('<x-aura::qr-code value="WIFI:S:Office;T:WPA;P:secret;;" show-value />');

    expect($link)->toContain('<a href="https://aura-ui.com"');
    // Anything else would become an anchor pointing at '#', which goes nowhere
    // and is announced as a link.
    expect($wifi)->not->toContain('<a href');
});

it('renders the value even with no encoder installed', function () {
    // The readable form of a QR code is the string inside it, so a missing
    // dependency degrades to the useful part rather than to an empty box.
    $html = Blade::render('<x-aura::qr-code value="https://aura-ui.com" />');

    expect($html)->toContain('https://aura-ui.com');
})->skip(fn () => QrCode::available(), 'bacon/bacon-qr-code is installed here');

it('points the combobox at the option a keyboard has landed on', function () {
    // Without aria-activedescendant, arrowing through the list changes a
    // colour and announces nothing.
    $html = Blade::render('<x-aura::combobox label="Country" :options="[\'it\' => \'Italy\', \'fr\' => \'France\']" />');

    expect($html)
        ->toContain('role="combobox"')
        ->toContain('aria-activedescendant')
        ->toContain('aria-controls')
        ->toContain('role="listbox"')
        ->toContain('role="option"');
});

it('ties the combobox label to the field it names', function () {
    $html = Blade::render('<x-aura::combobox label="Country" :options="[]" />');

    // The label carries an id of its own so the listbox can point at it rather
    // than repeating its text as a second name.
    expect($html)->toMatch('#<label id="[^"]+" for="[^"]+"[^>]*>Country</label>#');
});

it('submits a combobox value through a hidden field', function () {
    $html = Blade::render('<x-aura::combobox name="country" :options="[\'it\' => \'Italy\']" />');

    expect($html)->toContain('<input type="hidden" name="country"');
});

it('keeps a menu bar to one stop in the tab order', function () {
    // A roving tabindex is what separates a menu bar from a row of dropdowns:
    // Tab leaves the bar instead of walking through every menu in it.
    $html = Blade::render(<<<'BLADE'
        <x-aura::menubar label="Main">
            <x-aura::menubar.menu label="File" :index="0">
                <x-aura::menubar.item shortcut="Ctrl+S">Save</x-aura::menubar.item>
            </x-aura::menubar.menu>
            <x-aura::menubar.menu label="Edit" :index="1">
                <x-aura::menubar.item>Undo</x-aura::menubar.item>
            </x-aura::menubar.menu>
        </x-aura::menubar>
    BLADE);

    expect($html)
        ->toContain('role="menubar"')
        ->toContain('role="menu"')
        ->toContain('role="menuitem"')
        ->toContain('tabindex="0"')
        ->toContain('tabindex="-1"')
        ->toContain('aria-haspopup="true"');
});

it('hides the shortcut hint from assistive technology', function () {
    $html = Blade::render('<x-aura::menubar><x-aura::menubar.menu label="File"><x-aura::menubar.item shortcut="Ctrl+S">Save</x-aura::menubar.item></x-aura::menubar.menu></x-aura::menubar>');

    expect($html)->toContain('aura-menubar-shortcut')->toContain('aria-hidden="true"');
});

it('makes a menu item that goes somewhere a link and one that acts a button', function () {
    $link = Blade::render('<x-aura::menubar><x-aura::menubar.menu label="File"><x-aura::menubar.item href="/open">Open</x-aura::menubar.item></x-aura::menubar.menu></x-aura::menubar>');
    $action = Blade::render('<x-aura::menubar><x-aura::menubar.menu label="File"><x-aura::menubar.item>Save</x-aura::menubar.item></x-aura::menubar.menu></x-aura::menubar>');

    expect($link)->toContain('<a')->toContain('href="/open"');
    expect($action)->toContain('type="button"');
});

it('refuses a menu item href with a scheme it does not know', function () {
    $html = Blade::render('<x-aura::menubar><x-aura::menubar.menu label="File"><x-aura::menubar.item href="javascript:alert(1)">Run</x-aura::menubar.item></x-aura::menubar.menu></x-aura::menubar>');

    expect($html)->not->toContain('javascript:')->toContain('href="#"');
});

it('names the autocomplete field with its own label', function () {
    // The label had no `for` and the input had no id: the field's only
    // accessible name was its placeholder, which vanishes on the first
    // keystroke.
    $html = Blade::render('<x-aura::autocomplete label="City" :options="[\'Rome\']" />');

    expect($html)
        ->toMatch('#<label id="[^"]+" for="[^"]+" class="aura-label">City</label>#')
        ->toContain('aria-activedescendant')
        ->toContain('aria-controls');
});

it('stops the autocomplete options from sitting in the tab order', function () {
    // They were <button role="option">, which Tab walks into: the popup became
    // a detour through every suggestion.
    $html = Blade::render('<x-aura::autocomplete label="City" :options="[\'Rome\']" />');

    expect($html)->not->toMatch('/<button[^>]*aura-autocomplete-option/');
});
