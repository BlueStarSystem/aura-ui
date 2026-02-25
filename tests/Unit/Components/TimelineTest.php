<?php

use Illuminate\Support\Facades\Blade;

it('renders a timeline', function () {
    $html = Blade::render('<x-aura::timeline><x-aura::timeline.item>Event 1</x-aura::timeline.item></x-aura::timeline>');

    expect($html)
        ->toContain('aura-timeline')
        ->toContain('aura-timeline-item')
        ->toContain('Event 1');
});

it('renders vertical line', function () {
    $html = Blade::render('<x-aura::timeline>Items</x-aura::timeline>');

    expect($html)->toContain('--aura-surface-200');
});

it('renders alternate layout', function () {
    $html = Blade::render('<x-aura::timeline alternate>Items</x-aura::timeline>');

    expect($html)
        ->toContain('aura-timeline')
        ->toContain('Items');
});

it('renders timeline item with default color', function () {
    $html = Blade::render('<x-aura::timeline.item>Event</x-aura::timeline.item>');

    expect($html)
        ->toContain('aura-timeline-item')
        ->toContain('--aura-primary-500');
});

it('renders timeline item with success color', function () {
    $html = Blade::render('<x-aura::timeline.item color="success">Done</x-aura::timeline.item>');

    expect($html)->toContain('--aura-success-500');
});

it('renders timeline item with danger color', function () {
    $html = Blade::render('<x-aura::timeline.item color="danger">Error</x-aura::timeline.item>');

    expect($html)->toContain('--aura-danger-500');
});

it('renders timeline item with date', function () {
    $html = Blade::render('<x-aura::timeline.item date="Jan 15, 2026">Event</x-aura::timeline.item>');

    expect($html)
        ->toContain('<time')
        ->toContain('Jan 15, 2026');
});

it('renders timeline item content', function () {
    $html = Blade::render('<x-aura::timeline.item>My Content</x-aura::timeline.item>');

    expect($html)
        ->toContain('aura-timeline-content')
        ->toContain('My Content');
});

it('merges custom attributes on timeline', function () {
    $html = Blade::render('<x-aura::timeline id="my-timeline">Content</x-aura::timeline>');

    expect($html)->toContain('id="my-timeline"');
});
