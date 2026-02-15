<?php

use BlueStarSystem\AuraUI\DataTable\Filters\BooleanFilter;

it('creates a boolean filter', function () {
    $filter = BooleanFilter::make('is_active', 'Attivo');

    expect($filter->getKey())->toBe('is_active');
    expect($filter->getLabel())->toBe('Attivo');
    expect($filter->getType())->toBe('boolean');
});

it('has default labels', function () {
    $filter = BooleanFilter::make('is_active', 'Attivo');

    expect($filter->getTrueLabel())->toBe('Si');
    expect($filter->getFalseLabel())->toBe('No');
});

it('can set custom labels', function () {
    $filter = BooleanFilter::make('is_active', 'Attivo')
        ->labels('Attivo', 'Disattivo');

    expect($filter->getTrueLabel())->toBe('Attivo');
    expect($filter->getFalseLabel())->toBe('Disattivo');
});

it('detects empty values correctly', function () {
    $filter = BooleanFilter::make('is_active', 'Attivo');

    expect($filter->isEmpty(null))->toBeTrue();
    expect($filter->isEmpty(''))->toBeTrue();
    expect($filter->isEmpty(true))->toBeFalse();
    expect($filter->isEmpty(false))->toBeFalse();
    expect($filter->isEmpty('1'))->toBeFalse();
    expect($filter->isEmpty('0'))->toBeFalse();
});

it('converts to array', function () {
    $filter = BooleanFilter::make('is_active', 'Attivo')
        ->labels('On', 'Off');

    $arr = $filter->toArray();

    expect($arr)->toHaveKeys(['key', 'label', 'type', 'default', 'placeholder', 'trueLabel', 'falseLabel']);
    expect($arr['type'])->toBe('boolean');
    expect($arr['trueLabel'])->toBe('On');
    expect($arr['falseLabel'])->toBe('Off');
});
