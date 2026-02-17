<?php

it('renders with default props', function () {
    $view = $this->blade('<x-aura::empty-state />');

    $view->assertSee('aura-empty-state', false);
    $view->assertSee('No results');
});

it('renders with custom title', function () {
    $view = $this->blade('<x-aura::empty-state title="Nessun cliente" />');

    $view->assertSee('Nessun cliente');
});

it('renders with description', function () {
    $view = $this->blade('<x-aura::empty-state title="Vuoto" description="Aggiungi il primo elemento" />');

    $view->assertSee('Aggiungi il primo elemento');
    $view->assertSee('aura-empty-state-description', false);
});

it('renders without description by default', function () {
    $view = $this->blade('<x-aura::empty-state />');

    $view->assertDontSee('aura-empty-state-description', false);
});

it('renders slot content as actions', function () {
    $view = $this->blade('<x-aura::empty-state>
        <button>Aggiungi</button>
    </x-aura::empty-state>');

    $view->assertSee('aura-empty-state-actions', false);
    $view->assertSee('Aggiungi');
});

it('hides actions when slot is empty', function () {
    $view = $this->blade('<x-aura::empty-state />');

    $view->assertDontSee('aura-empty-state-actions', false);
});
