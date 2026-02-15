<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::color-picker label="Colore" wire:model="test" />');

    $view->assertSee('Colore');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('aura-color-picker-wrapper', false);
});

it('renders trigger button', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('aura-color-picker-button', false);
    $view->assertSee('aura-color-picker-trigger', false);
});

it('renders dropdown structure', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('aura-color-picker-dropdown', false);
});

it('renders default swatches', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('aura-color-swatches', false);
    $view->assertSee('#6366f1', false);
    $view->assertSee('#06b6d4', false);
    $view->assertSee('#10b981', false);
    $view->assertSee('#f59e0b', false);
    $view->assertSee('#ef4444', false);
    $view->assertSee('#ec4899', false);
    $view->assertSee('#8b5cf6', false);
    $view->assertSee('#000000', false);
    $view->assertSee('#ffffff', false);
});

it('renders custom swatches', function () {
    $view = $this->blade(
        '<x-aura::color-picker :swatches="$swatches" wire:model="test" />',
        ['swatches' => ['#ff0000', '#00ff00', '#0000ff']]
    );

    $view->assertSee('#ff0000', false);
    $view->assertSee('#00ff00', false);
    $view->assertSee('#0000ff', false);
    // Default swatches like #ef4444 should not be rendered as swatch buttons
    $view->assertDontSee('#ef4444', false);
});

it('renders hex input field', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('aura-color-hex-input', false);
    $view->assertSee('#000000', false);
});

it('renders swatch preview', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('aura-color-swatch-preview', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::color-picker error="Colore non valido" wire:model="test" />');

    $view->assertSee('Colore non valido');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::color-picker hint="Scegli un colore del brand" wire:model="test" />');

    $view->assertSee('Scegli un colore del brand');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::color-picker error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});

it('renders fallback text when no color selected', function () {
    $view = $this->blade('<x-aura::color-picker wire:model="test" />');

    $view->assertSee('Seleziona colore', false);
});
