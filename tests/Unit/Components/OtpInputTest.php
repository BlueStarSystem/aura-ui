<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::otp-input label="Codice OTP" wire:model="test" />');

    $view->assertSee('Codice OTP');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('aura-otp-wrapper', false);
});

it('renders 6 digit inputs by default', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('aura-otp-inputs', false);
    // 6 inputs with inputmode="numeric"
    $html = (string) $view;
    expect(substr_count($html, 'aura-otp-digit'))->toBe(6);
});

it('renders custom length digit inputs', function () {
    $view = $this->blade('<x-aura::otp-input :length="4" wire:model="test" />');

    $html = (string) $view;
    expect(substr_count($html, 'aura-otp-digit'))->toBe(4);
});

it('renders separator for 6-digit OTP', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('aura-otp-separator', false);
});

it('does not render separator for 4-digit OTP', function () {
    $view = $this->blade('<x-aura::otp-input :length="4" wire:model="test" />');

    $view->assertDontSee('aura-otp-separator', false);
});

it('renders inputs with numeric inputmode', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('inputmode="numeric"', false);
});

it('renders inputs with maxlength 1', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('maxlength="1"', false);
});

it('renders size variant class', function () {
    $view = $this->blade('<x-aura::otp-input size="lg" wire:model="test" />');

    $view->assertSee('aura-otp-lg', false);
});

it('renders default md size', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('aura-otp-md', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::otp-input error="Codice non valido" wire:model="test" />');

    $view->assertSee('Codice non valido');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::otp-input hint="Inserisci il codice ricevuto" wire:model="test" />');

    $view->assertSee('Inserisci il codice ricevuto');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::otp-input error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});

it('renders error class on digits when error is set', function () {
    $view = $this->blade('<x-aura::otp-input error="Errore" wire:model="test" />');

    $view->assertSee('aura-input-error', false);
});

it('renders autocomplete attribute for OTP', function () {
    $view = $this->blade('<x-aura::otp-input wire:model="test" />');

    $view->assertSee('autocomplete="one-time-code"', false);
});
