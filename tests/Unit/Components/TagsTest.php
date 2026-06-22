<?php

it('renders the tags wrapper and input', function () {
    $view = $this->blade('<x-aura::tags wire:model="t" />');
    $view->assertSee('aura-tags-wrapper', false);
    $view->assertSee('aura-tags-field', false);
});

it('renders the default placeholder', function () {
    $view = $this->blade('<x-aura::tags wire:model="t" />');
    $view->assertSee('Add tag...', false);
});

it('entangles the wire:model', function () {
    $view = $this->blade('<x-aura::tags wire:model="t" />');
    $view->assertSee("\$wire.entangle('t')", false);
});

it('renders the label', function () {
    $view = $this->blade('<x-aura::tags wire:model="t" label="Labels" />');
    $view->assertSee('Labels');
    $view->assertSee('aura-label', false);
});

it('exposes the chip x-for template', function () {
    $view = $this->blade('<x-aura::tags wire:model="t" />');
    $view->assertSee('x-for="(tag, idx) in tags"', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::tags wire:model="t" error="Required" />');
    $view->assertSee('Required');
    $view->assertSee('aura-input-error-text', false);
});
