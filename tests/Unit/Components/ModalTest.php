<?php

use Illuminate\Support\Facades\Blade;

it('renders with default state when no wire:model is set', function () {
    $html = Blade::render('<x-aura::modal name="demo">Body</x-aura::modal>');

    expect($html)
        ->toContain('aura-modal-content')
        ->toContain("x-data=\"{ open: false }\"")
        ->toContain('open-modal.window')
        ->toContain('demo');
});

it('renders title slot when provided', function () {
    $html = Blade::render('<x-aura::modal title="Conferma">Body</x-aura::modal>');

    expect($html)
        ->toContain('aura-modal-title')
        ->toContain('Conferma');
});

it('renders footer slot when provided', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::modal>
            Body
            <x-slot:footer>FooterContent</x-slot:footer>
        </x-aura::modal>
    BLADE);

    expect($html)
        ->toContain('aura-modal-footer')
        ->toContain('FooterContent');
});

it('renders trigger slot wrapped in a click handler', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::modal>
            <x-slot:trigger><button>Open</button></x-slot:trigger>
            Body
        </x-aura::modal>
    BLADE);

    expect($html)
        ->toContain('x-on:click="open = true"')
        ->toContain('Open');
});

it('entangles open state with wire:model property', function () {
    $html = Blade::render('<x-aura::modal wire:model="showModal">Body</x-aura::modal>');

    expect($html)
        ->toContain("x-data=\"{ open: \$wire.entangle('showModal') }\"")
        ->not->toContain('wire:model="showModal"');
});

it('entangles open state with .live modifier', function () {
    $html = Blade::render('<x-aura::modal wire:model.live="showModal">Body</x-aura::modal>');

    expect($html)
        ->toContain("x-data=\"{ open: \$wire.entangle('showModal').live }\"")
        ->not->toContain('wire:model.live="showModal"');
});

it('renders all maxWidth variants', function (string $size, string $expectedClass) {
    $html = Blade::render("<x-aura::modal maxWidth=\"{$size}\">Body</x-aura::modal>");

    expect($html)->toContain($expectedClass);
})->with([
    ['sm', 'aura-modal-sm'],
    ['md', 'aura-modal-md'],
    ['lg', 'aura-modal-lg'],
    ['xl', 'aura-modal-xl'],
    ['2xl', 'aura-modal-2xl'],
    ['full', 'aura-modal-full'],
]);

it('hides close button when closeable is false', function () {
    $html = Blade::render('<x-aura::modal title="Test" :closeable="false">Body</x-aura::modal>');

    expect($html)->not->toContain('aura-modal-close');
});

it('adds aura-glass class when glass prop is true', function () {
    $html = Blade::render('<x-aura::modal :glass="true">Body</x-aura::modal>');

    expect($html)->toContain('aura-glass');
});
