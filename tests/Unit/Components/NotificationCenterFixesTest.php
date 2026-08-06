<?php

use BlueStarSystem\AuraUI\Support\Html;
use Illuminate\Support\Facades\Blade;

/**
 * Three defects the BeautyFlow instance found while replacing their
 * hand-written notification centre with ours, in docs/proposals/2026-08-06.
 */
it('resolves the default item icon instead of falling back to a circle', function () {
    // The default was 'heroicon-o-bell'. The icon component looks up Lucide
    // names first, then a heroicon map whose keys are bare — so the prefixed
    // name matched nothing and every item drew an empty circle. The default.
    $html = Blade::render('<x-aura::notification-center.item title="T" />');

    expect($html)->not->toContain('r="10"');
});

it('announces the unread count on the trigger', function () {
    // aria-label REPLACES the button's content for a screen reader, so the
    // badge's number was read by nobody.
    expect(Blade::render('<x-aura::notification-center :count="2">x</x-aura::notification-center>'))
        ->toContain('2 unread');

    expect(Blade::render('<x-aura::notification-center :count="0">x</x-aura::notification-center>'))
        ->toContain('aria-label="Notifications"');
});

it('lets the application override the trigger label', function () {
    // The attribute bag lands on the wrapper, so there was no way in.
    expect(Blade::render('<x-aura::notification-center :count="3" label="Messages">x</x-aura::notification-center>'))
        ->toContain('aria-label="Messages"');
});

describe('slotIsEmpty', function () {
    it('sees through the markers Livewire wraps around a loop', function () {
        // ComponentSlot::isEmpty() trims, and trim does not remove a comment,
        // so a slot holding only Livewire's markers reported as full and the
        // empty state never appeared.
        expect(Html::slotIsEmpty('<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->'))->toBeTrue();
        expect(Html::slotIsEmpty("  \n\t "))->toBeTrue();
        expect(Html::slotIsEmpty(null))->toBeTrue();
    });

    it('still sees real content', function () {
        expect(Html::slotIsEmpty('<!--[if BLOCK]--><li>One</li><!--[if ENDBLOCK]-->'))->toBeFalse();
        expect(Html::slotIsEmpty('text'))->toBeFalse();
    });

    it('is what the components now use', function () {
        // notification-center, radial-progress and skip-link all chose a
        // fallback from isEmpty(); all three were wrong under Livewire.
        expect(Blade::render('<x-aura::skip-link />'))->toContain('Skip to main content');
        expect(Blade::render('<x-aura::radial-progress :value="40" />'))->toContain('40%');
    });
});
