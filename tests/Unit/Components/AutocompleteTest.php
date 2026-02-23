<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::autocomplete label="Citta" wire:model="test" />');

    $view->assertSee('Citta');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders with default placeholder', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertSee('Search...');
});

it('renders with custom placeholder', function () {
    $view = $this->blade('<x-aura::autocomplete placeholder="Cerca citta..." wire:model="test" />');

    $view->assertSee('Cerca citta...');
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertSee('aura-autocomplete-wrapper', false);
});

it('renders combobox role', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertSee('role="combobox"', false);
});

it('renders dropdown structure', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertSee('aura-autocomplete-dropdown', false);
});

it('renders no-results text', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertSee('No results');
    $view->assertSee('aura-autocomplete-no-results', false);
});

it('renders custom no-results text', function () {
    $view = $this->blade('<x-aura::autocomplete no-results-text="Niente trovato" wire:model="test" />');

    $view->assertSee('Niente trovato');
});

it('renders with options as json', function () {
    $view = $this->blade(
        '<x-aura::autocomplete :options="$options" wire:model="test" />',
        ['options' => ['Milano', 'Roma', 'Napoli']]
    );

    $view->assertSee('Milano', false);
    $view->assertSee('Roma', false);
    $view->assertSee('Napoli', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::autocomplete error="Seleziona un valore" wire:model="test" />');

    $view->assertSee('Seleziona un valore');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::autocomplete hint="Inizia a digitare" wire:model="test" />');

    $view->assertSee('Inizia a digitare');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::autocomplete error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});

it('renders input with error class', function () {
    $view = $this->blade('<x-aura::autocomplete error="Errore" wire:model="test" />');

    $view->assertSee('aura-input-error', false);
});

it('renders clear button when clearable', function () {
    $view = $this->blade('<x-aura::autocomplete wire:model="test" />');

    $view->assertSee('aura-datepicker-clear', false);
});

it('does not render clear button when not clearable', function () {
    $view = $this->blade('<x-aura::autocomplete :clearable="false" wire:model="test" />');

    $view->assertDontSee('aura-datepicker-clear', false);
});
