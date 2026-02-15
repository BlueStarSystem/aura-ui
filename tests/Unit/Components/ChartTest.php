<?php

use Illuminate\Support\Facades\Blade;

it('renders chart container', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['Jan', 'Feb'],
        'datasets' => [['data' => [10, 20], 'label' => 'Sales']],
    ]);

    expect($html)
        ->toContain('aura-chart')
        ->toContain('x-data');
});

it('renders canvas element', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)
        ->toContain('<canvas')
        ->toContain('x-ref="canvas"');
});

it('sets default type to line', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('line');
});

it('renders bar type', function () {
    $html = Blade::render('<x-aura::chart type="bar" :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('bar');
});

it('renders pie type', function () {
    $html = Blade::render('<x-aura::chart type="pie" :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('pie');
});

it('renders doughnut type', function () {
    $html = Blade::render('<x-aura::chart type="doughnut" :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('doughnut');
});

it('sets custom height', function () {
    $html = Blade::render('<x-aura::chart height="400px" :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('height: 400px');
});

it('defaults to 300px height', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('height: 300px');
});

it('includes labels in config', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['January', 'February'],
        'datasets' => [['data' => [10, 20]]],
    ]);

    expect($html)
        ->toContain('January')
        ->toContain('February');
});

it('includes dataset data in config', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [42], 'label' => 'Revenue']],
    ]);

    expect($html)->toContain('Revenue');
});

it('initializes Chart.js on init', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('new Chart');
});

it('has destroy method', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('destroy()');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::chart :labels="$labels" :datasets="$datasets" id="sales-chart" />', [
        'labels' => ['A'],
        'datasets' => [['data' => [1]]],
    ]);

    expect($html)->toContain('id="sales-chart"');
});
