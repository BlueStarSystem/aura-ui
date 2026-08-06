<?php

use Illuminate\Support\Facades\Blade;

/**
 * Every component that interpolates a value into a style attribute.
 *
 * Blade's {{ }} escapes the quote, so the value cannot break out of the
 * attribute — but a semicolon inside it starts a second declaration, which is
 * enough to attach a background:url() and make the browser call somebody
 * else's server. All six of these were verified injectable before the guard.
 */
it('keeps a hostile length out of the style attribute', function (string $markup, string $fallback) {
    $html = Blade::render($markup);

    expect($html)
        ->not->toContain('evil.test')
        ->toContain($fallback);
})->with([
    'chart' => ['<x-aura::chart height="1px; background:url(//evil.test/a)" />', 'height: 300px'],
    'context-menu' => ['<x-aura::context-menu width="1px; background:url(//evil.test/b)">x</x-aura::context-menu>', 'width: 200px'],
    'editor' => ['<x-aura::editor min-height="1px; background:url(//evil.test/c)" />', 'min-height: 150px'],
    'notification-center' => ['<x-aura::notification-center max-height="1px; background:url(//evil.test/d)">x</x-aura::notification-center>', 'max-height: 24rem'],
    'popover' => ['<x-aura::popover width="1px; background:url(//evil.test/e)">x</x-aura::popover>', 'width: 300px'],
    'aspect-ratio' => ['<x-aura::aspect-ratio ratio="1; background:url(//evil.test/f)">x</x-aura::aspect-ratio>', 'aspect-ratio: 16/9'],
]);

it('still honours a legitimate length', function (string $markup, string $expected) {
    expect(Blade::render($markup))->toContain($expected);
})->with([
    'chart' => ['<x-aura::chart height="42vh" />', 'height: 42vh'],
    'context-menu' => ['<x-aura::context-menu width="18rem">x</x-aura::context-menu>', 'width: 18rem'],
    'editor' => ['<x-aura::editor min-height="500px" />', 'min-height: 500px'],
    'notification-center' => ['<x-aura::notification-center max-height="30rem">x</x-aura::notification-center>', 'max-height: 30rem'],
    'popover' => ['<x-aura::popover width="24rem">x</x-aura::popover>', 'width: 24rem'],
    'aspect-ratio' => ['<x-aura::aspect-ratio ratio="4/3">x</x-aura::aspect-ratio>', 'aspect-ratio: 4/3'],
]);

/**
 * The other three reach a style attribute through values they compute
 * themselves — arithmetic, or a match() with a default — so there is nothing
 * to guard. If someone later swaps that for a prop, these fail.
 */
it('composes drawer, progress and slider styles from values they control', function (string $markup, string $expected) {
    expect(Blade::render($markup))->toContain($expected);
})->with([
    'progress clamps above' => ['<x-aura::progress :value="500" :max="100" />', 'width: 100%'],
    'progress clamps below' => ['<x-aura::progress :value="-50" :max="100" />', 'width: 0%'],
    'drawer unknown position' => ['<x-aura::drawer position="nonsense">x</x-aura::drawer>', 'right:0;top:0;bottom:0;'],
    'drawer unknown size' => ['<x-aura::drawer size="nonsense">x</x-aura::drawer>', 'max-width:448px;'],
]);
