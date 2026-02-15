<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::date-picker label="Data" wire:model="test" />');

    $view->assertSee('Data');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders with custom placeholder', function () {
    $view = $this->blade('<x-aura::date-picker placeholder="Seleziona data" wire:model="test" />');

    $view->assertSee('Seleziona data');
});

it('renders with default placeholder', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    $view->assertSee('gg/mm/aaaa');
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    $view->assertSee('aura-datepicker-wrapper', false);
});

it('renders calendar icon', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    $view->assertSee('aura-datepicker-icon', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::date-picker error="Campo obbligatorio" wire:model="test" />');

    $view->assertSee('Campo obbligatorio');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::date-picker hint="Formato gg/mm/aaaa" wire:model="test" />');

    $view->assertSee('Formato gg/mm/aaaa');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::date-picker error="Errore" hint="Suggerimento" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Suggerimento');
});

it('renders italian locale day names by default', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    // JSON in HTML attributes is HTML-encoded
    $view->assertSee('&quot;Lu&quot;', false);
    $view->assertSee('&quot;Gi&quot;', false);
    $view->assertSee('&quot;Gennaio&quot;', false);
});

it('renders english locale day names', function () {
    $view = $this->blade('<x-aura::date-picker locale="en" wire:model="test" />');

    $view->assertSee('&quot;Mo&quot;', false);
    $view->assertSee('&quot;Fr&quot;', false);
    $view->assertSee('&quot;January&quot;', false);
});

it('renders german locale day names', function () {
    $view = $this->blade('<x-aura::date-picker locale="de" wire:model="test" />');

    $view->assertSee('&quot;Mo&quot;', false);
    $view->assertSee('&quot;Fr&quot;', false);
    $view->assertSee('&quot;Januar&quot;', false);
});

it('renders input with error class when error is set', function () {
    $view = $this->blade('<x-aura::date-picker error="Errore" wire:model="test" />');

    $view->assertSee('aura-input-error', false);
});

it('renders datepicker dropdown structure', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    $view->assertSee('aura-datepicker-dropdown', false);
    $view->assertSee('aura-datepicker-header', false);
    $view->assertSee('aura-datepicker-weekdays', false);
    $view->assertSee('aura-datepicker-grid', false);
});

it('renders clear button when clearable', function () {
    $view = $this->blade('<x-aura::date-picker wire:model="test" />');

    $view->assertSee('aura-datepicker-clear', false);
});

it('does not render clear button when not clearable', function () {
    $view = $this->blade('<x-aura::date-picker :clearable="false" wire:model="test" />');

    $view->assertDontSee('aura-datepicker-clear', false);
});
