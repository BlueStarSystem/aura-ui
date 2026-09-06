<?php

use Illuminate\Support\Facades\Blade;

/*
 * Reported by the TempGuard instance (2026-09-06): the fields that keep their
 * own Alpine state and post through a hidden input let wire:model fall on the
 * wrapper div, where Livewire ignores it in silence.
 */

it('entangles the iban-field with the wire:model property', function () {
    $html = Blade::render('<x-aura::iban-field name="iban" wire:model="iban" />');

    expect($html)
        ->toContain("\$wire.entangle('iban')")
        ->not->toMatch('/<div[^>]*wire:model/');
});

it('entangles the iban-field live when asked', function () {
    $html = Blade::render('<x-aura::iban-field name="iban" wire:model.live="iban" />');

    expect($html)->toContain("\$wire.entangle('iban').live");
});

it('entangles the phone-input with the wire:model property', function () {
    $html = Blade::render('<x-aura::phone-input name="phone" wire:model="phone" />');

    expect($html)
        ->toContain("\$wire.entangle('phone')")
        ->not->toMatch('/<div[^>]*wire:model/');
});

it('keeps a plain initial value when there is no wire:model', function () {
    $html = Blade::render('<x-aura::phone-input name="phone" value="+39 333 1234567" />');

    expect($html)
        ->not->toContain('entangle')
        ->toContain("national: '333 1234567'");
});
