<?php

it('renders a range input with the slider class', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" :min="0" :max="100" />');
    $view->assertSee('aura-slider-wrapper', false);
    $view->assertSee('type="range"', false);
    $view->assertSee('aura-slider', false);
});

it('applies the color modifier class', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" color="success" />');
    $view->assertSee('aura-slider-success', false);
});

it('shows the value when show-value is true', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" :show-value="true" />');
    $view->assertSee('aura-slider-value', false);
});

it('renders prefix and suffix on the labels', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" prefix="$" suffix="k" :min="1" :max="9" />');
    $view->assertSee('$1k', false);
    $view->assertSee('$9k', false);
});

it('renders the label', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" label="Volume" />');
    $view->assertSee('Volume');
    $view->assertSee('aura-label', false);
});

it('entangles the wire:model', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" />');
    $view->assertSee("\$wire.entangle('vol')", false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::slider wire:model="vol" error="Required" />');
    $view->assertSee('Required');
    $view->assertSee('aura-input-error-text', false);
});
