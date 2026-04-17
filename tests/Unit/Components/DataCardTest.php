<?php

use Illuminate\Support\Facades\Blade;

it('renders data card with title and value', function () {
    $html = Blade::render('<x-aura::data-card title="Revenue" value="€12,450" />');

    expect($html)->toContain('aura-data-card');
    expect($html)->toContain('Revenue');
    expect($html)->toContain('€12,450');
});

it('renders positive change indicator', function () {
    $html = Blade::render('<x-aura::data-card title="Users" value="1,234" change="+12%" change-type="positive" />');

    expect($html)->toContain('+12%');
    expect($html)->toContain('aura-data-card__change--positive');
});

it('renders negative change indicator', function () {
    $html = Blade::render('<x-aura::data-card title="Errors" value="42" change="-5%" change-type="negative" />');

    expect($html)->toContain('-5%');
    expect($html)->toContain('aura-data-card__change--negative');
});

it('renders with icon', function () {
    $html = Blade::render('<x-aura::data-card title="Sales" value="99" icon="heroicon-o-shopping-bag" />');

    expect($html)->toContain('aura-data-card__icon');
});

it('renders footer slot', function () {
    $html = Blade::render('
        <x-aura::data-card title="Revenue" value="€500">
            <x-slot:footer>
                <a href="/reports">View report</a>
            </x-slot:footer>
        </x-aura::data-card>
    ');

    expect($html)->toContain('View report');
    expect($html)->toContain('aura-data-card__footer');
});

it('renders as link when href provided', function () {
    $html = Blade::render('<x-aura::data-card title="Orders" value="50" href="/orders" />');

    expect($html)->toContain('href="/orders"');
    expect($html)->toContain('<a');
});

it('renders sparkline when data provided', function () {
    $html = Blade::render('<x-aura::data-card title="Trend" value="100" :sparkline="[10, 20, 15, 30, 25]" />');

    expect($html)->toContain('aura-data-card__sparkline');
    expect($html)->toContain('svg');
});

it('passes custom attributes', function () {
    $html = Blade::render('<x-aura::data-card title="Test" value="1" id="my-card" />');

    expect($html)->toContain('id="my-card"');
});
