<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::editor label="Descrizione" wire:model="test" />');

    $view->assertSee('Descrizione');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::editor wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::editor wire:model="test" />');

    $view->assertSee('aura-editor-wrapper', false);
});

it('renders editor structure', function () {
    $view = $this->blade('<x-aura::editor wire:model="test" />');

    $view->assertSee('aura-editor', false);
    $view->assertSee('aura-editor-toolbar', false);
    $view->assertSee('aura-editor-content', false);
});

it('renders default toolbar buttons', function () {
    $view = $this->blade('<x-aura::editor wire:model="test" />');

    $view->assertSee('aura-editor-btn', false);
    // Default toolbar: bold,italic,underline,link,list-ordered,list-unordered,heading
    $view->assertSee("title=\"Grassetto\"", false);
    $view->assertSee("title=\"Corsivo\"", false);
    $view->assertSee("title=\"Sottolineato\"", false);
    $view->assertSee("title=\"Link\"", false);
    $view->assertSee("title=\"Lista numerata\"", false);
    $view->assertSee("title=\"Lista puntata\"", false);
    $view->assertSee("title=\"Intestazione\"", false);
});

it('renders custom toolbar buttons', function () {
    $view = $this->blade('<x-aura::editor toolbar="bold,italic" wire:model="test" />');

    $view->assertSee("title=\"Grassetto\"", false);
    $view->assertSee("title=\"Corsivo\"", false);
    $view->assertDontSee("title=\"Sottolineato\"", false);
    $view->assertDontSee("title=\"Link\"", false);
});

it('renders with placeholder', function () {
    $view = $this->blade('<x-aura::editor placeholder="Inizia a scrivere..." wire:model="test" />');

    $view->assertSee('data-placeholder="Inizia a scrivere..."', false);
});

it('renders with default placeholder', function () {
    $view = $this->blade('<x-aura::editor wire:model="test" />');

    $view->assertSee('data-placeholder="Scrivi qui..."', false);
});

it('renders contenteditable area', function () {
    $view = $this->blade('<x-aura::editor wire:model="test" />');

    $view->assertSee('contenteditable="true"', false);
    $view->assertSee('role="textbox"', false);
    $view->assertSee('aria-multiline="true"', false);
});

it('renders contenteditable false when disabled', function () {
    $view = $this->blade('<x-aura::editor :disabled="true" wire:model="test" />');

    $view->assertSee('contenteditable="false"', false);
    $view->assertSee('aura-editor-disabled', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::editor error="Campo obbligatorio" wire:model="test" />');

    $view->assertSee('Campo obbligatorio');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::editor hint="Massimo 500 caratteri" wire:model="test" />');

    $view->assertSee('Massimo 500 caratteri');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::editor error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});

it('renders error class on editor when error is set', function () {
    $view = $this->blade('<x-aura::editor error="Errore" wire:model="test" />');

    $view->assertSee('aura-editor-error', false);
});

it('renders with custom min height', function () {
    $view = $this->blade('<x-aura::editor min-height="300px" wire:model="test" />');

    $view->assertSee('min-height: 300px', false);
});
