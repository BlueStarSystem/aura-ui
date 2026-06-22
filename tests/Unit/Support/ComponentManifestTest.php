<?php

use BlueStarSystem\AuraUI\Support\ComponentManifest;

it('merges entries and resolves transitive deps deps-first', function () {
    $m = new ComponentManifest([
        'button' => ['tier' => 'free', 'files' => ['button.blade.php'], 'deps' => ['icon']],
        'icon'   => ['tier' => 'free', 'files' => ['icon.blade.php'], 'deps' => []],
        'alert'  => ['tier' => 'free', 'files' => ['alert.blade.php'], 'deps' => ['icon']],
    ]);

    expect($m->has('button'))->toBeTrue()
        ->and($m->tier('button'))->toBe('free')
        ->and($m->resolve('button'))->toBe(['icon', 'button'])
        ->and($m->resolve('icon'))->toBe(['icon']);
});

it('drops deps that are not in the manifest', function () {
    $m = new ComponentManifest([
        'card' => ['tier' => 'free', 'files' => ['card.blade.php'], 'deps' => ['card', 'ghost']],
    ]);

    expect($m->resolve('card'))->toBe(['card']);
});

it('throws when getting an unknown component', function () {
    $m = new ComponentManifest([]);
    expect(fn () => $m->get('nope'))->toThrow(InvalidArgumentException::class);
});
