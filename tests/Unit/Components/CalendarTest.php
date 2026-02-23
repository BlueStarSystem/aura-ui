<?php

use Illuminate\Support\Facades\Blade;

it('renders calendar container', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar')
        ->toContain('x-data');
});

it('renders calendar header with navigation', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-header')
        ->toContain('aura-calendar-nav')
        ->toContain('aura-calendar-title');
});

it('renders previous month button', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('prevMonth()')
        ->toContain('aria-label="Previous month"');
});

it('renders next month button', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('nextMonth()')
        ->toContain('aria-label="Next month"');
});

it('renders today button', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('goToday()');
});

it('renders day name headers', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-dayname')
        ->toContain('Mon')
        ->toContain('Fri');
});

it('renders calendar grid', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('aura-calendar-grid');
});

it('renders calendar cells', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-cell')
        ->toContain('aura-calendar-date');
});

it('highlights today', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('aura-calendar-today');
});

it('marks other month cells', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('aura-calendar-other');
});

it('renders events', function () {
    $html = Blade::render('<x-aura::calendar :events="$events" />', [
        'events' => [['date' => '2026-02-15', 'title' => 'Meeting', 'color' => '#6366f1']],
    ]);

    expect($html)->toContain('aura-calendar-event');
});

it('passes events to alpine data', function () {
    $html = Blade::render('<x-aura::calendar :events="$events" />', [
        'events' => [['date' => '2026-01-01', 'title' => 'New Year']],
    ]);

    expect($html)->toContain('New Year');
});

it('uses custom locale', function () {
    $html = Blade::render('<x-aura::calendar locale="it" />');

    expect($html)->toContain("'it'");
});

it('supports sunday start of week', function () {
    $html = Blade::render('<x-aura::calendar :startOfWeek="0" />');

    expect($html)->toContain('startOfWeek: 0');
});

it('has getEvents method', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('getEvents(');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::calendar id="my-calendar" />');

    expect($html)->toContain('id="my-calendar"');
});
