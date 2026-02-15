<?php

it('renders with title and value', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" />');

    $view->assertSee('aura-stats-card', false);
    $view->assertSee('Clienti');
    $view->assertSee('128');
});

it('renders as div by default', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" />');

    $view->assertSee('<div', false);
    $view->assertDontSee('aura-card-hover', false);
});

it('renders as anchor with href', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" href="/clients" />');

    $view->assertSee('<a', false);
    $view->assertSee('href="/clients"', false);
    $view->assertSee('aura-card-hover', false);
});

it('renders change with positive type', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" change="+12%" changeType="positive" />');

    $view->assertSee('+12%');
    $view->assertSee('aura-stats-change-positive', false);
});

it('renders change with negative type', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" change="-5%" changeType="negative" />');

    $view->assertSee('-5%');
    $view->assertSee('aura-stats-change-negative', false);
});

it('renders change with neutral type', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" change="0%" />');

    $view->assertSee('aura-stats-change-neutral', false);
});

it('hides change when not provided', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" />');

    $view->assertDontSee('aura-stats-change', false);
});

it('renders icon when provided', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" icon="users" />');

    $view->assertSee('aura-stats-icon', false);
});

it('hides icon when not provided', function () {
    $view = $this->blade('<x-aura::stats-card title="Clienti" value="128" />');

    $view->assertDontSee('aura-stats-icon', false);
});
