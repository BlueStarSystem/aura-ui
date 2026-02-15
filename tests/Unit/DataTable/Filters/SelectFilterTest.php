<?php

use BlueStarSystem\AuraUI\DataTable\Filters\SelectFilter;

it('creates a select filter', function () {
    $filter = SelectFilter::make('status', 'Stato');

    expect($filter->getKey())->toBe('status');
    expect($filter->getLabel())->toBe('Stato');
    expect($filter->getType())->toBe('select');
});

it('can set options', function () {
    $filter = SelectFilter::make('status', 'Stato')->options([
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
    ]);

    expect($filter->getOptions())->toBe([
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
    ]);
});

it('is not multiple by default', function () {
    $filter = SelectFilter::make('status', 'Stato');

    expect($filter->isMultiple())->toBeFalse();
});

it('can be made multiple', function () {
    $filter = SelectFilter::make('status', 'Stato')->multiple();

    expect($filter->isMultiple())->toBeTrue();
});

it('can set placeholder', function () {
    $filter = SelectFilter::make('status', 'Stato')->placeholder('Seleziona...');

    expect($filter->getPlaceholder())->toBe('Seleziona...');
});

it('can set default value', function () {
    $filter = SelectFilter::make('status', 'Stato')->default('active');

    expect($filter->getDefaultValue())->toBe('active');
});

it('detects empty values', function () {
    $filter = SelectFilter::make('status', 'Stato');

    expect($filter->isEmpty(null))->toBeTrue();
    expect($filter->isEmpty(''))->toBeTrue();
    expect($filter->isEmpty([]))->toBeTrue();
    expect($filter->isEmpty('active'))->toBeFalse();
});

it('converts to array', function () {
    $filter = SelectFilter::make('status', 'Stato')
        ->options(['active' => 'Attivo'])
        ->multiple()
        ->default('active')
        ->placeholder('Seleziona');

    $arr = $filter->toArray();

    expect($arr)->toHaveKeys(['key', 'label', 'type', 'default', 'placeholder', 'options', 'multiple']);
    expect($arr['key'])->toBe('status');
    expect($arr['type'])->toBe('select');
    expect($arr['options'])->toBe(['active' => 'Attivo']);
    expect($arr['multiple'])->toBeTrue();
});
