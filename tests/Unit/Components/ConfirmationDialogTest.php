<?php

use Illuminate\Support\Facades\Blade;

it('renders with default props', function () {
    $html = Blade::render('<x-aura::confirmation-dialog />');

    expect($html)
        ->toContain('x-data')
        ->toContain('aura-confirm-overlay')
        ->toContain('aura-confirm-dialog');
});

it('renders with custom name', function () {
    $html = Blade::render('<x-aura::confirmation-dialog name="delete-user" />');

    expect($html)->toContain('delete-user');
});

it('renders danger variant by default', function () {
    $html = Blade::render('<x-aura::confirmation-dialog />');

    expect($html)->toContain('aura-confirm-danger');
});

it('renders warning variant', function () {
    $html = Blade::render('<x-aura::confirmation-dialog variant="warning" />');

    expect($html)->toContain('aura-confirm-warning');
});

it('renders info variant', function () {
    $html = Blade::render('<x-aura::confirmation-dialog variant="info" />');

    expect($html)->toContain('aura-confirm-info');
});

it('renders custom title', function () {
    $html = Blade::render('<x-aura::confirmation-dialog title="Delete this item?" />');

    expect($html)->toContain('Delete this item?');
});

it('renders default title', function () {
    $html = Blade::render('<x-aura::confirmation-dialog />');

    expect($html)->toContain('Are you sure?');
});

it('renders message', function () {
    $html = Blade::render('<x-aura::confirmation-dialog message="This cannot be undone." />');

    expect($html)->toContain('This cannot be undone.');
});

it('renders custom confirm text', function () {
    $html = Blade::render('<x-aura::confirmation-dialog confirmText="Delete" />');

    expect($html)->toContain('Delete');
});

it('renders custom cancel text', function () {
    $html = Blade::render('<x-aura::confirmation-dialog cancelText="Annulla" />');

    expect($html)->toContain('Annulla');
});

it('renders require input field', function () {
    $html = Blade::render('<x-aura::confirmation-dialog requireInput="DELETE" />');

    expect($html)
        ->toContain('aura-confirm-input')
        ->toContain('DELETE')
        ->toContain('x-model="inputValue"')
        ->toContain('x-bind:disabled');
});

it('does not render input field by default', function () {
    $html = Blade::render('<x-aura::confirmation-dialog />');

    expect($html)->not->toContain('aura-confirm-input');
});

it('renders icon based on variant', function () {
    $html = Blade::render('<x-aura::confirmation-dialog />');

    expect($html)->toContain('aura-confirm-icon');
});

it('listens to open-confirm event', function () {
    $html = Blade::render('<x-aura::confirmation-dialog name="test" />');

    expect($html)->toContain('open-confirm');
});

it('dispatches confirmed event', function () {
    $html = Blade::render('<x-aura::confirmation-dialog name="test" />');

    expect($html)->toContain("confirmed");
});

it('uses teleport to body', function () {
    $html = Blade::render('<x-aura::confirmation-dialog />');

    expect($html)->toContain('x-teleport="body"');
});

it('renders max width class', function () {
    $html = Blade::render('<x-aura::confirmation-dialog maxWidth="md" />');

    expect($html)->toContain('aura-confirm-md');
});

it('renders slot content as message', function () {
    $html = Blade::render('<x-aura::confirmation-dialog>Custom message content</x-aura::confirmation-dialog>');

    expect($html)->toContain('Custom message content');
});

it('merges custom attributes', function () {
    $html = Blade::render('<x-aura::confirmation-dialog id="my-dialog" />');

    expect($html)->toContain('id="my-dialog"');
});
