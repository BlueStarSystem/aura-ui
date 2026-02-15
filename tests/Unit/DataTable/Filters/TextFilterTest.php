<?php

use BlueStarSystem\AuraUI\DataTable\Filters\TextFilter;

it('creates a text filter', function () {
    $filter = TextFilter::make('name', 'Nome');

    expect($filter->getKey())->toBe('name');
    expect($filter->getLabel())->toBe('Nome');
    expect($filter->getType())->toBe('text');
});

it('can set placeholder', function () {
    $filter = TextFilter::make('name', 'Nome')->placeholder('Cerca nome...');

    expect($filter->getPlaceholder())->toBe('Cerca nome...');
});

it('can set default value', function () {
    $filter = TextFilter::make('name', 'Nome')->default('test');

    expect($filter->getDefaultValue())->toBe('test');
});

it('detects empty values', function () {
    $filter = TextFilter::make('name', 'Nome');

    expect($filter->isEmpty(null))->toBeTrue();
    expect($filter->isEmpty(''))->toBeTrue();
    expect($filter->isEmpty([]))->toBeTrue();
    expect($filter->isEmpty('test'))->toBeFalse();
});

it('converts to array', function () {
    $filter = TextFilter::make('name', 'Nome')
        ->placeholder('Cerca...')
        ->default('test');

    $arr = $filter->toArray();

    expect($arr)->toHaveKeys(['key', 'label', 'type', 'default', 'placeholder']);
    expect($arr['type'])->toBe('text');
    expect($arr['default'])->toBe('test');
    expect($arr['placeholder'])->toBe('Cerca...');
});
