<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::tags-input label="Tags" wire:model="test" />');

    $view->assertSee('Tags');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders with default placeholder', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertSee('Aggiungi tag...');
});

it('renders with custom placeholder', function () {
    $view = $this->blade('<x-aura::tags-input placeholder="Inserisci keyword" wire:model="test" />');

    $view->assertSee('Inserisci keyword');
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertSee('aura-tags-wrapper', false);
});

it('renders tags container', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertSee('aura-tags-container', false);
});

it('renders input field', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertSee('aura-tags-input-field', false);
});

it('renders suggestions dropdown structure', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertSee('aura-tags-suggestions', false);
});

it('renders max counter when max is set', function () {
    $view = $this->blade('<x-aura::tags-input :max="5" wire:model="test" />');

    $view->assertSee('aura-tags-count', false);
    $view->assertSee('>5<', false);
});

it('does not render max counter when max is not set', function () {
    $view = $this->blade('<x-aura::tags-input wire:model="test" />');

    $view->assertDontSee('aura-tags-count', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::tags-input error="Aggiungi almeno un tag" wire:model="test" />');

    $view->assertSee('Aggiungi almeno un tag');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::tags-input hint="Premi invio per aggiungere" wire:model="test" />');

    $view->assertSee('Premi invio per aggiungere');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::tags-input error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});

it('renders with error class on input', function () {
    $view = $this->blade('<x-aura::tags-input error="Errore" wire:model="test" />');

    $view->assertSee('aura-input-error', false);
});
