<?php

it('renders with default props', function () {
    $view = $this->blade('<x-aura::progress :value="50" />');

    $view->assertSee('aura-progress', false);
    $view->assertSee('aura-progress-bar', false);
    $view->assertSee('role="progressbar"', false);
    $view->assertSee('aria-valuenow="50"', false);
});

it('renders with correct percentage width', function () {
    $view = $this->blade('<x-aura::progress :value="75" :max="100" />');

    $view->assertSee('width: 75%', false);
});

it('clamps percentage to 0-100 range', function () {
    $view = $this->blade('<x-aura::progress :value="150" :max="100" />');
    $view->assertSee('width: 100%', false);
});

it('renders with custom max', function () {
    $view = $this->blade('<x-aura::progress :value="25" :max="50" />');

    $view->assertSee('width: 50%', false);
    $view->assertSee('aria-valuemax="50"', false);
});

it('renders color variants', function () {
    $view = $this->blade('<x-aura::progress :value="50" color="success" />');

    $view->assertSee('aura-progress-success', false);
});

it('renders size variants', function () {
    $view = $this->blade('<x-aura::progress :value="50" size="lg" />');

    $view->assertSee('aura-progress-lg', false);
});

it('renders label when enabled', function () {
    $view = $this->blade('<x-aura::progress :value="75" :label="true" />');

    $view->assertSee('aura-progress-label', false);
    $view->assertSee('75%');
});

it('hides label by default', function () {
    $view = $this->blade('<x-aura::progress :value="50" />');

    $view->assertDontSee('aura-progress-label', false);
});

it('renders striped variant', function () {
    $view = $this->blade('<x-aura::progress :value="50" :striped="true" />');

    $view->assertSee('aura-progress-striped', false);
});

it('renders animated variant', function () {
    $view = $this->blade('<x-aura::progress :value="50" :animated="true" />');

    $view->assertSee('aura-progress-animated', false);
});
