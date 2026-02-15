<?php

it('renders description list', function () {
    $view = $this->blade('<x-aura::description-list>
        <x-aura::description-list.item label="Nome" value="Mario Rossi" />
    </x-aura::description-list>');

    $view->assertSee('aura-description-list', false);
    $view->assertSee('aura-description-item', false);
    $view->assertSee('Nome');
    $view->assertSee('Mario Rossi');
});

it('renders item with label and value', function () {
    $view = $this->blade('<x-aura::description-list.item label="Email" value="test@example.com" />');

    $view->assertSee('aura-description-label', false);
    $view->assertSee('aura-description-value', false);
    $view->assertSee('Email');
    $view->assertSee('test@example.com');
});

it('renders item with slot content', function () {
    $view = $this->blade('<x-aura::description-list.item label="Stato">
        <span class="badge">Attivo</span>
    </x-aura::description-list.item>');

    $view->assertSee('Stato');
    $view->assertSee('Attivo');
});

it('renders multiple items', function () {
    $view = $this->blade('<x-aura::description-list>
        <x-aura::description-list.item label="Nome" value="Mario" />
        <x-aura::description-list.item label="Cognome" value="Rossi" />
        <x-aura::description-list.item label="Email" value="mario@test.com" />
    </x-aura::description-list>');

    $view->assertSee('Mario');
    $view->assertSee('Rossi');
    $view->assertSee('mario@test.com');
});
