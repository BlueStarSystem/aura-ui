<?php

it('registers the config', function () {
    expect(config('aura-ui'))->toBeArray();
    expect(config('aura-ui.prefix'))->toBe('aura');
    expect(config('aura-ui.dark_mode'))->toBe('class');
});

it('registers playground route when enabled', function () {
    $routes = collect(app('router')->getRoutes()->getRoutes());
    $playground = $routes->first(fn ($r) => $r->getName() === 'aura.playground');

    expect($playground)->not->toBeNull();
    expect($playground->uri())->toBe('aura/playground');
});

it('playground returns 200', function () {
    $response = $this->get('/aura/playground');

    $response->assertStatus(200);
    $response->assertSee('Aura UI');
});

it('loads component views', function () {
    $view = view('aura::components.button', [
        'variant' => 'primary',
        'size' => 'md',
        'outline' => false,
        'gradient' => false,
        'loading' => false,
        'disabled' => false,
        'icon' => null,
        'iconRight' => null,
        'iconOnly' => false,
        'href' => null,
        'type' => 'button',
        'slot' => 'Test',
    ]);

    expect($view->name())->toBe('aura::components.button');
});
