<?php

use Illuminate\Support\Facades\Blade;

it('renders notification center with count badge', function () {
    $html = Blade::render('<x-aura::notification-center :count="3" />');

    expect($html)->toContain('aura-notification-center');
    expect($html)->toContain('3');
});

it('renders zero count without badge', function () {
    $html = Blade::render('<x-aura::notification-center :count="0" />');

    expect($html)->toContain('aura-notification-center');
    expect($html)->not->toContain('aura-notification-center__badge');
});

it('renders notification items', function () {
    $html = Blade::render('
        <x-aura::notification-center :count="1">
            <x-aura::notification-center.item title="New order" time="5 min ago" />
        </x-aura::notification-center>
    ');

    expect($html)->toContain('New order');
    expect($html)->toContain('5 min ago');
});

it('renders unread item with visual indicator', function () {
    $html = Blade::render('
        <x-aura::notification-center :count="1">
            <x-aura::notification-center.item title="Unread" :read="false" />
        </x-aura::notification-center>
    ');

    expect($html)->toContain('aura-notification-center__item--unread');
});

it('renders empty slot when no items', function () {
    $html = Blade::render('
        <x-aura::notification-center :count="0">
            <x-slot:empty>Nothing here</x-slot:empty>
        </x-aura::notification-center>
    ');

    expect($html)->toContain('Nothing here');
});

it('renders footer slot', function () {
    $html = Blade::render('
        <x-aura::notification-center :count="0">
            <x-slot:footer>View all</x-slot:footer>
        </x-aura::notification-center>
    ');

    expect($html)->toContain('View all');
});
