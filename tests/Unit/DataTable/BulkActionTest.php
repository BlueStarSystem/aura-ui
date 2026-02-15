<?php

use BlueStarSystem\AuraUI\DataTable\BulkAction;

it('creates a bulk action with key and label', function () {
    $action = BulkAction::make('delete', 'Elimina');

    expect($action->getKey())->toBe('delete');
    expect($action->getLabel())->toBe('Elimina');
});

it('has primary color by default', function () {
    $action = BulkAction::make('delete', 'Elimina');

    expect($action->getColor())->toBe('primary');
});

it('does not require confirmation by default', function () {
    $action = BulkAction::make('delete', 'Elimina');

    expect($action->requiresConfirmation())->toBeFalse();
    expect($action->getConfirmMessage())->toBeNull();
    expect($action->getConfirmTitle())->toBeNull();
});

it('can set icon', function () {
    $action = BulkAction::make('delete', 'Elimina')->icon('trash');

    expect($action->getIcon())->toBe('trash');
});

it('can set color', function () {
    $action = BulkAction::make('delete', 'Elimina')->color('danger');

    expect($action->getColor())->toBe('danger');
});

it('can set confirmation', function () {
    $action = BulkAction::make('delete', 'Elimina')
        ->confirm('Sei sicuro?', 'Attenzione');

    expect($action->requiresConfirmation())->toBeTrue();
    expect($action->getConfirmMessage())->toBe('Sei sicuro?');
    expect($action->getConfirmTitle())->toBe('Attenzione');
});

it('uses default confirm title', function () {
    $action = BulkAction::make('delete', 'Elimina')->confirm('Sei sicuro?');

    expect($action->getConfirmTitle())->toBe('Conferma');
});

it('deselects after execution by default', function () {
    $action = BulkAction::make('delete', 'Elimina');

    expect($action->shouldDeselectAfter())->toBeTrue();
});

it('can keep selected after execution', function () {
    $action = BulkAction::make('export', 'Esporta')->keepSelected();

    expect($action->shouldDeselectAfter())->toBeFalse();
});

it('executes action callback with ids', function () {
    $executed = false;
    $receivedIds = [];

    $action = BulkAction::make('delete', 'Elimina')
        ->action(function ($ids) use (&$executed, &$receivedIds) {
            $executed = true;
            $receivedIds = $ids;
            return count($ids);
        });

    $result = $action->execute(['1', '2', '3']);

    expect($executed)->toBeTrue();
    expect($receivedIds)->toBe(['1', '2', '3']);
    expect($result)->toBe(3);
});

it('returns null when no callback is set', function () {
    $action = BulkAction::make('delete', 'Elimina');

    expect($action->execute(['1', '2']))->toBeNull();
});

it('converts to array', function () {
    $action = BulkAction::make('delete', 'Elimina')
        ->icon('trash')
        ->color('danger')
        ->confirm('Sei sicuro?');

    $arr = $action->toArray();

    expect($arr)->toHaveKeys(['key', 'label', 'icon', 'color', 'requiresConfirmation', 'confirmMessage', 'confirmTitle']);
    expect($arr['key'])->toBe('delete');
    expect($arr['label'])->toBe('Elimina');
    expect($arr['icon'])->toBe('trash');
    expect($arr['color'])->toBe('danger');
    expect($arr['requiresConfirmation'])->toBeTrue();
});

it('supports method chaining', function () {
    $action = BulkAction::make('delete', 'Elimina')
        ->icon('trash')
        ->color('danger')
        ->confirm('Sicuro?')
        ->keepSelected();

    expect($action->getIcon())->toBe('trash');
    expect($action->getColor())->toBe('danger');
    expect($action->requiresConfirmation())->toBeTrue();
    expect($action->shouldDeselectAfter())->toBeFalse();
});
