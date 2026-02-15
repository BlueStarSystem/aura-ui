<?php

use BlueStarSystem\AuraUI\Traits\WithAuraInlineEdit;

// Create a test class that uses the trait
class InlineEditTestComponent
{
    use WithAuraInlineEdit;
}

it('is not editing by default', function () {
    $component = new InlineEditTestComponent();

    expect($component->editingCell)->toBeNull();
    expect($component->editingRow)->toBeNull();
    expect($component->editingValue)->toBe('');
    expect($component->isEditingAny())->toBeFalse();
});

it('starts editing a cell', function () {
    $component = new InlineEditTestComponent();
    $component->startEditing('row-1', 'name', 'Mario');

    expect($component->editingRow)->toBe('row-1');
    expect($component->editingCell)->toBe('name');
    expect($component->editingValue)->toBe('Mario');
    expect($component->isEditingAny())->toBeTrue();
});

it('checks if specific cell is editing', function () {
    $component = new InlineEditTestComponent();
    $component->startEditing('row-1', 'name', 'Mario');

    expect($component->isEditing('row-1', 'name'))->toBeTrue();
    expect($component->isEditing('row-1', 'email'))->toBeFalse();
    expect($component->isEditing('row-2', 'name'))->toBeFalse();
});

it('cancels editing', function () {
    $component = new InlineEditTestComponent();
    $component->startEditing('row-1', 'name', 'Mario');
    $component->cancelEditing();

    expect($component->editingRow)->toBeNull();
    expect($component->editingCell)->toBeNull();
    expect($component->editingValue)->toBe('');
    expect($component->isEditingAny())->toBeFalse();
});

it('starts editing with empty value', function () {
    $component = new InlineEditTestComponent();
    $component->startEditing('row-1', 'notes');

    expect($component->editingValue)->toBe('');
    expect($component->isEditingAny())->toBeTrue();
});
