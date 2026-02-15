<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::slider label="Volume" wire:model="test" />');

    $view->assertSee('Volume');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertSee('aura-slider-wrapper', false);
});

it('renders range input', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertSee('type="range"', false);
    $view->assertSee('aura-slider', false);
});

it('renders with default min max step', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertSee('min="0"', false);
    $view->assertSee('max="100"', false);
    $view->assertSee('step="1"', false);
});

it('renders with custom min max step', function () {
    $view = $this->blade('<x-aura::slider :min="10" :max="50" :step="5" wire:model="test" />');

    $view->assertSee('min="10"', false);
    $view->assertSee('max="50"', false);
    $view->assertSee('step="5"', false);
});

it('renders min and max labels', function () {
    $view = $this->blade('<x-aura::slider :min="0" :max="100" wire:model="test" />');

    $view->assertSee('aura-slider-labels', false);
    $view->assertSee('aura-slider-min', false);
    $view->assertSee('aura-slider-max', false);
});

it('renders value display when showValue is true', function () {
    $view = $this->blade('<x-aura::slider :show-value="true" wire:model="test" />');

    $view->assertSee('aura-slider-value', false);
    $view->assertSee('aura-slider-header', false);
});

it('does not render value display by default', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertDontSee('aura-slider-value', false);
});

it('renders header when label is present', function () {
    $view = $this->blade('<x-aura::slider label="Test" wire:model="test" />');

    $view->assertSee('aura-slider-header', false);
});

it('does not render header without label or showValue', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertDontSee('aura-slider-header', false);
});

it('renders with prefix and suffix on labels', function () {
    $view = $this->blade('<x-aura::slider prefix="$" suffix="k" :min="0" :max="100" wire:model="test" />');

    $view->assertSee('$0k', false);
    $view->assertSee('$100k', false);
});

it('renders with prefix and suffix on value display', function () {
    $view = $this->blade('<x-aura::slider prefix="$" suffix="k" :show-value="true" wire:model="test" />');

    $view->assertSee('aura-slider-value', false);
    $view->assertSee('$', false);
    $view->assertSee('k', false);
});

it('renders color variant class', function () {
    $view = $this->blade('<x-aura::slider color="success" wire:model="test" />');

    $view->assertSee('aura-slider-success', false);
});

it('renders primary color by default', function () {
    $view = $this->blade('<x-aura::slider wire:model="test" />');

    $view->assertSee('aura-slider-primary', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::slider error="Valore non valido" wire:model="test" />');

    $view->assertSee('Valore non valido');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::slider hint="Sposta il cursore" wire:model="test" />');

    $view->assertSee('Sposta il cursore');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::slider error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});
