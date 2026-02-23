<?php

it('renders with label', function () {
    $view = $this->blade('<x-aura::time-picker label="Orario" wire:model="test" />');

    $view->assertSee('Orario');
    $view->assertSee('aura-label', false);
});

it('renders without label', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    $view->assertDontSee('aura-label', false);
});

it('renders with default placeholder', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    $view->assertSee('HH:MM');
});

it('renders with custom placeholder', function () {
    $view = $this->blade('<x-aura::time-picker placeholder="Seleziona ora" wire:model="test" />');

    $view->assertSee('Seleziona ora');
});

it('renders wrapper class', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    $view->assertSee('aura-timepicker-wrapper', false);
});

it('renders time dropdown structure', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    $view->assertSee('aura-timepicker-dropdown', false);
    $view->assertSee('aura-timepicker-list', false);
    $view->assertSee('aura-timepicker-search', false);
});

it('generates time slots with default step of 15 minutes', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    // Default: 00:00 to 23:59, step 15 => 00:00, 00:15, 00:30, 00:45, ...
    $view->assertSee('00:00', false);
    $view->assertSee('00:15', false);
    $view->assertSee('00:30', false);
    $view->assertSee('12:00', false);
});

it('generates time slots with custom step', function () {
    $view = $this->blade('<x-aura::time-picker :step="30" wire:model="test" />');

    $view->assertSee('00:00', false);
    $view->assertSee('00:30', false);
    $view->assertSee('01:00', false);
});

it('generates time slots with custom min and max', function () {
    $view = $this->blade('<x-aura::time-picker min="09:00" max="17:00" :step="60" wire:model="test" />');

    $view->assertSee('09:00', false);
    $view->assertSee('10:00', false);
    $view->assertSee('17:00', false);
});

it('renders error text', function () {
    $view = $this->blade('<x-aura::time-picker error="Orario non valido" wire:model="test" />');

    $view->assertSee('Orario non valido');
    $view->assertSee('aura-input-error-text', false);
});

it('renders hint text', function () {
    $view = $this->blade('<x-aura::time-picker hint="Seleziona un orario" wire:model="test" />');

    $view->assertSee('Seleziona un orario');
    $view->assertSee('aura-input-hint', false);
});

it('renders error instead of hint when both present', function () {
    $view = $this->blade('<x-aura::time-picker error="Errore" hint="Aiuto" wire:model="test" />');

    $view->assertSee('Errore');
    $view->assertDontSee('Aiuto');
});

it('renders input with error class', function () {
    $view = $this->blade('<x-aura::time-picker error="Errore" wire:model="test" />');

    $view->assertSee('aura-input-error', false);
});

it('renders clock icon', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    $view->assertSee('aura-datepicker-icon', false);
});

it('renders clear button when clearable', function () {
    $view = $this->blade('<x-aura::time-picker wire:model="test" />');

    $view->assertSee('aura-datepicker-clear', false);
});
