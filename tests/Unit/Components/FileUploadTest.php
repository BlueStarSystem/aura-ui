<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::file-upload label="Documento" wire:model="test" />');

    $view->assertSee('Documento');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertSee('aura-file-upload-wrapper', false);
});

it('renders upload zone', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertSee('aura-file-upload-zone', false);
});

it('renders default placeholder text', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertSee('Trascina qui o clicca per selezionare');
    $view->assertSee('aura-file-upload-placeholder', false);
});

it('renders custom placeholder via slot', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test">
        <p>Carica il tuo file qui</p>
    </x-aura::file-upload>');

    $view->assertSee('Carica il tuo file qui');
});

it('renders accept attribute on input', function () {
    $view = $this->blade('<x-aura::file-upload accept="image/*" wire:model="test" />');

    $view->assertSee('accept="image/*"', false);
});

it('renders without accept attribute when not specified', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $html = (string) $view;
    // The accept attribute should not appear on the input when not specified
    expect($html)->not->toMatch('/accept="[^"]*"/');
});

it('renders multiple attribute when specified', function () {
    $view = $this->blade('<x-aura::file-upload :multiple="true" wire:model="test" />');

    $view->assertSee('multiple', false);
});

it('renders max size hint in placeholder', function () {
    $view = $this->blade('<x-aura::file-upload max-size="5MB" wire:model="test" />');

    $view->assertSee('Max 5MB');
    $view->assertSee('aura-file-upload-hint', false);
});

it('does not render max size hint when not specified', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertDontSee('aura-file-upload-hint', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::file-upload error="File troppo grande" wire:model="test" />');

    $view->assertSee('File troppo grande');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::file-upload hint="Solo PDF" wire:model="test" />');

    $view->assertSee('Solo PDF');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::file-upload error="Errore" hint="Suggerimento" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Suggerimento');
});

it('renders hidden file input', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertSee('aura-file-upload-input', false);
    $view->assertSee('type="file"', false);
});

it('renders file list structure', function () {
    $view = $this->blade('<x-aura::file-upload wire:model="test" />');

    $view->assertSee('aura-file-upload-list', false);
});

it('renders disabled state', function () {
    $view = $this->blade('<x-aura::file-upload :disabled="true" wire:model="test" />');

    $view->assertSee('disabled', false);
});
