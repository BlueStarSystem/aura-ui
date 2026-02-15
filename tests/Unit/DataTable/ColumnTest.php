<?php

use BlueStarSystem\AuraUI\DataTable\Column;
use Carbon\Carbon;

it('creates a column with key and label', function () {
    $col = Column::make('name', 'Nome');

    expect($col->getKey())->toBe('name');
    expect($col->getLabel())->toBe('Nome');
});

it('auto-generates label from key', function () {
    $col = Column::make('first_name');

    expect($col->getLabel())->toBe('First name');
});

it('is not sortable by default', function () {
    $col = Column::make('name', 'Nome');

    expect($col->isSortable())->toBeFalse();
});

it('can be made sortable', function () {
    $col = Column::make('name', 'Nome')->sortable();

    expect($col->isSortable())->toBeTrue();
    expect($col->getSortField())->toBe('name');
});

it('can set custom sort field', function () {
    $col = Column::make('name', 'Nome')->sortable('users.name');

    expect($col->getSortField())->toBe('users.name');
});

it('can be made searchable', function () {
    $col = Column::make('name', 'Nome')->searchable();

    expect($col->isSearchable())->toBeTrue();
});

it('can be made inline editable', function () {
    $col = Column::make('name', 'Nome')->inlineEditable();

    expect($col->isInlineEditable())->toBeTrue();
});

it('is visible by default', function () {
    $col = Column::make('name', 'Nome');

    expect($col->isVisible())->toBeTrue();
});

it('can be hidden', function () {
    $col = Column::make('name', 'Nome')->hidden();

    expect($col->isVisible())->toBeFalse();
});

it('formats date values', function () {
    $col = Column::make('created_at', 'Creato il')->date('d/m/Y');

    $row = (object) ['created_at' => Carbon::create(2026, 2, 15)];
    expect($col->getValue($row))->toBe('15/02/2026');
});

it('formats number values', function () {
    $col = Column::make('price', 'Prezzo')->number('2,.,.');

    $row = (object) ['price' => 1234.56];
    // Format '2,.,.' = 2 decimals, '.' dec separator, '.' thousands separator
    expect($col->getValue($row))->toBe('1.234.56');
});

it('applies custom format callback', function () {
    $col = Column::make('status', 'Stato')->format(fn ($v) => strtoupper($v));

    $row = (object) ['status' => 'active'];
    expect($col->getValue($row))->toBe('ACTIVE');
});

it('can set alignment', function () {
    $col = Column::make('price', 'Prezzo')->alignRight();

    expect($col->getAlign())->toBe('right');
});

it('can set width', function () {
    $col = Column::make('name', 'Nome')->width('200px');

    expect($col->getWidth())->toBe('200px');
});

it('creates actions column', function () {
    $col = Column::actions();

    expect($col->isActions())->toBeTrue();
    expect($col->isSortable())->toBeFalse();
    expect($col->isSearchable())->toBeFalse();
    expect($col->isToggleable())->toBeFalse();
});

it('can be made filterable', function () {
    $col = Column::make('status', 'Stato')->filterable([
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
    ]);

    expect($col->getFilterOptions())->toBe(['active' => 'Attivo', 'inactive' => 'Inattivo']);
    expect($col->getFilterType())->toBe('select');
});

it('converts to array', function () {
    $col = Column::make('name', 'Nome')->sortable()->searchable();
    $arr = $col->toArray();

    expect($arr)->toHaveKeys(['key', 'label', 'sortable', 'searchable', 'visible', 'align']);
    expect($arr['key'])->toBe('name');
    expect($arr['sortable'])->toBeTrue();
    expect($arr['searchable'])->toBeTrue();
});

it('supports method chaining', function () {
    $col = Column::make('name', 'Nome')
        ->sortable()
        ->searchable()
        ->inlineEditable()
        ->alignCenter()
        ->width('150px');

    expect($col->isSortable())->toBeTrue();
    expect($col->isSearchable())->toBeTrue();
    expect($col->isInlineEditable())->toBeTrue();
    expect($col->getAlign())->toBe('center');
    expect($col->getWidth())->toBe('150px');
});
