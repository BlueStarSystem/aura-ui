<?php

use Illuminate\Support\Facades\Blade;

it('renders toast container', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('aura-toasts')
        ->toContain('x-data');
});

it('renders top-right position by default', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)->toContain('aura-toasts-top-right');
});

it('renders custom position', function (string $position) {
    $html = Blade::render("<x-aura::toasts position=\"{$position}\" />");

    expect($html)->toContain("aura-toasts-{$position}");
})->with(['top-left', 'top-right', 'bottom-left', 'bottom-right', 'top-center', 'bottom-center']);

it('sets z-index from CSS variable', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)->toContain('z-aura-toast');
});

it('sets max toasts', function () {
    $html = Blade::render('<x-aura::toasts :maxToasts="3" />');

    expect($html)->toContain('maxToasts: 3');
});

it('sets default duration', function () {
    $html = Blade::render('<x-aura::toasts :duration="3000" />');

    expect($html)->toContain('defaultDuration: 3000');
});

it('listens for aura:toast event', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)->toContain('aura:toast');
});

it('has add and remove methods', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('add(')
        ->toContain('remove(');
});

it('renders toast template with role alert', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('aura-toast')
        ->toContain('role="alert"');
});

it('renders close button', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('aura-toast-close')
        ->toContain('aria-label="Close"');
});

it('renders progress bar', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('aura-toast-progress')
        ->toContain('aura-toast-progress-bar');
});

it('renders icons for each toast type', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('toast.type === \'success\'')
        ->toContain('toast.type === \'warning\'')
        ->toContain('toast.type === \'info\'');
});

it('renders toast content elements', function () {
    $html = Blade::render('<x-aura::toasts />');

    expect($html)
        ->toContain('aura-toast-title')
        ->toContain('aura-toast-message')
        ->toContain('aura-toast-content');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::toasts id="notifications" />');

    expect($html)->toContain('id="notifications"');
});
