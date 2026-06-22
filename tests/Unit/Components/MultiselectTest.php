<?php

it('renders the multiselect wrapper and control', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[\'a\'=>\'A\',\'b\'=>\'B\']" />');
    $view->assertSee('aura-multiselect-wrapper', false);
    $view->assertSee('aura-multiselect-control', false);
});

it('embeds the options as json', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[\'php\'=>\'PHP\']" />');
    $view->assertSee('PHP', false);
});

it('entangles the wire:model', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[]" />');
    $view->assertSee("\$wire.entangle('s')", false);
});

it('renders a search box when searchable', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[]" :searchable="true" />');
    $view->assertSee('aura-multiselect-search', false);
});

it('omits the search box when not searchable', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[]" :searchable="false" />');
    $view->assertDontSee('aura-multiselect-search', false);
});

it('exposes role listbox and option templates', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[\'a\'=>\'A\']" />');
    $view->assertSee('role="listbox"', false);
    $view->assertSee('x-for="opt in filteredOptions', false);
});

it('renders the label and error', function () {
    $view = $this->blade('<x-aura::multiselect wire:model="s" :options="[]" label="Skills" error="Pick one" />');
    $view->assertSee('Skills');
    $view->assertSee('aura-label', false);
    $view->assertSee('Pick one');
    $view->assertSee('aura-input-error-text', false);
});
