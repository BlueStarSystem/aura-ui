<?php

use BlueStarSystem\AuraUI\DataTable\Filters\DateRangeFilter;

it('creates a date range filter', function () {
    $filter = DateRangeFilter::make('created_at', 'Data creazione');

    expect($filter->getKey())->toBe('created_at');
    expect($filter->getLabel())->toBe('Data creazione');
    expect($filter->getType())->toBe('date_range');
});

it('can set column', function () {
    $filter = DateRangeFilter::make('created', 'Data')
        ->column('created_at');

    $arr = $filter->toArray();
    expect($arr['key'])->toBe('created');
});

it('can set format', function () {
    $filter = DateRangeFilter::make('created_at', 'Data')
        ->format('d/m/Y');

    $arr = $filter->toArray();
    expect($arr['format'])->toBe('d/m/Y');
});

it('detects empty values correctly', function () {
    $filter = DateRangeFilter::make('created_at', 'Data');

    expect($filter->isEmpty(null))->toBeTrue();
    expect($filter->isEmpty('string'))->toBeTrue();
    expect($filter->isEmpty([]))->toBeTrue();
    expect($filter->isEmpty(['from' => '', 'to' => '']))->toBeTrue();
    expect($filter->isEmpty(['from' => null, 'to' => null]))->toBeTrue();
    expect($filter->isEmpty(['from' => '2026-01-01', 'to' => '']))->toBeFalse();
    expect($filter->isEmpty(['from' => '', 'to' => '2026-12-31']))->toBeFalse();
    expect($filter->isEmpty(['from' => '2026-01-01', 'to' => '2026-12-31']))->toBeFalse();
});

it('converts to array with format', function () {
    $filter = DateRangeFilter::make('created_at', 'Data')
        ->format('d/m/Y');

    $arr = $filter->toArray();

    expect($arr)->toHaveKeys(['key', 'label', 'type', 'default', 'placeholder', 'format']);
    expect($arr['type'])->toBe('date_range');
    expect($arr['format'])->toBe('d/m/Y');
});

it('has default Y-m-d format', function () {
    $filter = DateRangeFilter::make('created_at', 'Data');

    $arr = $filter->toArray();
    expect($arr['format'])->toBe('Y-m-d');
});
