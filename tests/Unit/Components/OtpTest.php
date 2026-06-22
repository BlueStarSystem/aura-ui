<?php

it('renders length single-digit inputs', function () {
    $view = $this->blade('<x-aura::otp wire:model="c" :length="4" />');
    $view->assertSee('aura-otp-wrapper', false);
    expect(substr_count($view->value(), 'aura-otp-digit'))->toBe(4);
});

it('defaults to 6 digits', function () {
    $view = $this->blade('<x-aura::otp wire:model="c" />');
    expect(substr_count($view->value(), 'aura-otp-digit'))->toBe(6);
});

it('entangles the wire:model', function () {
    $view = $this->blade('<x-aura::otp wire:model="c" />');
    $view->assertSee("\$wire.entangle('c')", false);
});

it('renders the label', function () {
    $view = $this->blade('<x-aura::otp wire:model="c" label="Code" />');
    $view->assertSee('Code');
    $view->assertSee('aura-label', false);
});

it('uses numeric inputmode', function () {
    $view = $this->blade('<x-aura::otp wire:model="c" />');
    $view->assertSee('inputmode="numeric"', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::otp wire:model="c" error="Invalid" />');
    $view->assertSee('Invalid');
    $view->assertSee('aura-input-error-text', false);
});
