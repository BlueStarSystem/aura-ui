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

it('renders previous navigation button', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('prev()')
        ->toContain('t.prev');
});

it('renders next navigation button', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('next()')
        ->toContain('t.next');
});

it('renders today button', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('goToday()');
});

it('renders view switcher', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-views')
        ->toContain('aura-calendar-view-btn')
        ->toContain('x-text="t.month"')
        ->toContain('x-text="t.week"')
        ->toContain('x-text="t.day"');
});

it('renders month view by default', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain("view: 'month'")
        ->toContain('aura-calendar-month')
        ->toContain('aura-calendar-grid');
});

it('renders day name headers in month view', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-dayname')
        ->toContain('Mon')
        ->toContain('Fri');
});

it('renders calendar cells in month view', function () {
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

// Week view tests

it('renders week view structure', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-week')
        ->toContain('aura-calendar-week-header')
        ->toContain('aura-calendar-week-allday')
        ->toContain('aura-calendar-week-body');
});

it('accepts week as initial view', function () {
    $html = Blade::render('<x-aura::calendar view="week" />');

    expect($html)->toContain("view: 'week'");
});

it('has week navigation methods', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('prevWeek()')
        ->toContain('nextWeek()');
});

it('has weekDays computed property', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('weekDays')
        ->toContain('weekStart');
});

it('renders week view all-day section', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('x-text="t.allDay"')
        ->toContain('getAllDayEvents(');
});

it('renders week view time grid', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('formatHour(')
        ->toContain('getEventsForHour(');
});

// Day view tests

it('renders day view structure', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('aura-calendar-day')
        ->toContain('aura-calendar-day-allday')
        ->toContain('aura-calendar-day-body');
});

it('accepts day as initial view', function () {
    $html = Blade::render('<x-aura::calendar view="day" />');

    expect($html)->toContain("view: 'day'");
});

it('has day navigation methods', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('prevDay()')
        ->toContain('nextDay()');
});

it('has day title computed property', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)->toContain('dayTitle');
});

// New props tests

it('accepts eventStartKey prop', function () {
    $html = Blade::render('<x-aura::calendar eventStartKey="begins_at" />');

    expect($html)->toContain("eventStartKey: 'begins_at'");
});

it('accepts eventEndKey prop', function () {
    $html = Blade::render('<x-aura::calendar eventEndKey="ends_at" />');

    expect($html)->toContain("eventEndKey: 'ends_at'");
});

it('accepts businessHoursStart prop', function () {
    $html = Blade::render('<x-aura::calendar :businessHoursStart="6" />');

    expect($html)->toContain('businessHoursStart: 6');
});

it('accepts businessHoursEnd prop', function () {
    $html = Blade::render('<x-aura::calendar :businessHoursEnd="22" />');

    expect($html)->toContain('businessHoursEnd: 22');
});

it('has default business hours 8 to 20', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('businessHoursStart: 8')
        ->toContain('businessHoursEnd: 20');
});

// Navigation dispatch tests

it('has unified prev and next navigation', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('prev()')
        ->toContain('next()');
});

it('has dynamic aria labels for navigation', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain('t.prev')
        ->toContain('t.next')
        ->toContain('t.month')
        ->toContain('t.week')
        ->toContain('t.day');
});

it('has view switcher aria labels', function () {
    $html = Blade::render('<x-aura::calendar />');

    expect($html)
        ->toContain(':aria-label="t.month"')
        ->toContain(':aria-label="t.week"')
        ->toContain(':aria-label="t.day"');
});

it('renders italian locale translations', function () {
    $html = Blade::render('<x-aura::calendar locale="it" />');

    expect($html)
        ->toContain('Lun')
        ->toContain('Ven')
        ->toContain('Dom')
        ->toContain('\u0022month\u0022:\u0022Mese\u0022')
        ->toContain('\u0022today\u0022:\u0022Oggi\u0022')
        ->toContain('\u0022allDay\u0022:\u0022Tutto il giorno\u0022');
});

it('falls back to english for unsupported locale', function () {
    $html = Blade::render('<x-aura::calendar locale="zh" />');

    expect($html)
        ->toContain('Mon')
        ->toContain('Fri')
        ->toContain('\u0022month\u0022:\u0022Month\u0022')
        ->toContain('\u0022today\u0022:\u0022Today\u0022');
});
