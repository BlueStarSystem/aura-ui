<?php

use Illuminate\Support\Facades\Blade;

it('renders each new form control', function (string $markup, string $expected) {
    expect(Blade::render($markup))->toContain($expected);
})->with([
    'label' => ['<x-aura::label for="x">Email</x-aura::label>', 'for="x"'],
    'number-input' => ['<x-aura::number-input name="qty" />', 'type="number"'],
    'password-input' => ['<x-aura::password-input name="pwd" />', 'type="password"'],
    'range-slider' => ['<x-aura::range-slider name="price" />', 'aura-range-slider'],
]);

it('announces a required field with a word, not only an asterisk', function () {
    $html = Blade::render('<x-aura::label for="x" required>Email</x-aura::label>');

    // The asterisk is decoration and hidden; the word is what gets read out.
    expect($html)
        ->toContain('aria-hidden="true"')
        ->toContain('Required');
});

it('gives the password toggle a state a screen reader can read', function () {
    $html = Blade::render('<x-aura::password-input name="pwd" />');

    expect($html)
        ->toContain('aria-pressed')
        ->toContain('Show password');
});

it('keeps the field a real password field until it is revealed', function () {
    // Faking the mask with a font loses the browser's password handling,
    // including offering to save it.
    expect(Blade::render('<x-aura::password-input name="pwd" />'))
        ->toContain('type="password"')
        ->toContain("revealed ? 'text' : 'password'");
});

it('stops the wheel silently changing a number', function () {
    expect(Blade::render('<x-aura::number-input name="qty" />'))->toContain('x-on:wheel.prevent');
});

it('keeps the stepper buttons out of the tab order', function () {
    // They duplicate what the arrow keys already do on a focused number field;
    // in the tab order they would double the stops in every form.
    $html = Blade::render('<x-aura::number-input name="qty" />');

    expect(substr_count($html, 'tabindex="-1"'))->toBe(2);
});

it('honours min, max and step', function () {
    $html = Blade::render('<x-aura::number-input name="qty" :min="1" :max="10" :step="0.5" />');

    expect($html)
        ->toContain('min="1"')
        ->toContain('max="10"')
        ->toContain('step="0.5"');
});

it('gives each range handle its own accessible name', function () {
    $html = Blade::render('<x-aura::range-slider name="price" label="Price" />');

    expect($html)
        ->toContain('Price — Minimum')
        ->toContain('Price — Maximum');
});

it('builds the range slider from two real range inputs', function () {
    // Native inputs bring keyboard support and value announcements; a
    // div-and-pointer-maths slider has to reimplement both.
    $html = Blade::render('<x-aura::range-slider name="price" />');

    expect(substr_count($html, 'type="range"'))->toBe(2);
    expect($html)->toContain('name="price[from]"')->toContain('name="price[to]"');
});

it('associates the error with every new control', function (string $markup, string $prefix) {
    $html = Blade::render($markup);

    expect($html)
        ->toContain('aria-invalid="true"')
        ->toContain('role="alert"')
        ->toContain('id="'.$prefix.'-description"');
})->with([
    'number-input' => ['<x-aura::number-input name="qty" error="Too many" />', 'qty'],
    'password-input' => ['<x-aura::password-input name="pwd" error="Too short" />', 'pwd'],
    'range-slider' => ['<x-aura::range-slider name="price" error="Out of range" />', 'price'],
]);
