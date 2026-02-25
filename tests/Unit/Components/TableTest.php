<?php

use Illuminate\Support\Facades\Blade;

it('renders a basic table', function () {
    $html = Blade::render('
        <x-aura::table>
            <x-aura::table.head>
                <x-aura::table.row>
                    <x-aura::table.header>Name</x-aura::table.header>
                </x-aura::table.row>
            </x-aura::table.head>
            <x-aura::table.body>
                <x-aura::table.row>
                    <x-aura::table.cell>John</x-aura::table.cell>
                </x-aura::table.row>
            </x-aura::table.body>
        </x-aura::table>
    ');

    expect($html)
        ->toContain('aura-table')
        ->toContain('aura-table-wrapper')
        ->toContain('<table')
        ->toContain('<thead')
        ->toContain('<tbody')
        ->toContain('<tr')
        ->toContain('<th')
        ->toContain('<td')
        ->toContain('Name')
        ->toContain('John');
});

it('renders striped variant', function () {
    $html = Blade::render('<x-aura::table striped><x-aura::table.body><x-aura::table.row><x-aura::table.cell>A</x-aura::table.cell></x-aura::table.row></x-aura::table.body></x-aura::table>');

    expect($html)->toContain('aura-table-striped');
});

it('renders hoverable variant', function () {
    $html = Blade::render('<x-aura::table hoverable><x-aura::table.body><x-aura::table.row><x-aura::table.cell>A</x-aura::table.cell></x-aura::table.row></x-aura::table.body></x-aura::table>');

    expect($html)->toContain('aura-table-hoverable');
});

it('renders bordered variant', function () {
    $html = Blade::render('<x-aura::table bordered><x-aura::table.body><x-aura::table.row><x-aura::table.cell>A</x-aura::table.cell></x-aura::table.row></x-aura::table.body></x-aura::table>');

    expect($html)->toContain('aura-table-bordered');
});

it('renders compact variant', function () {
    $html = Blade::render('<x-aura::table compact><x-aura::table.body><x-aura::table.row><x-aura::table.cell>A</x-aura::table.cell></x-aura::table.row></x-aura::table.body></x-aura::table>');

    expect($html)->toContain('aura-table-compact');
});

it('renders header with align center', function () {
    $html = Blade::render('<x-aura::table.header align="center">Price</x-aura::table.header>');

    expect($html)
        ->toContain('text-center')
        ->toContain('Price');
});

it('renders header with align right', function () {
    $html = Blade::render('<x-aura::table.header align="right">Total</x-aura::table.header>');

    expect($html)->toContain('text-right');
});

it('renders cell with align center', function () {
    $html = Blade::render('<x-aura::table.cell align="center">42</x-aura::table.cell>');

    expect($html)
        ->toContain('text-center')
        ->toContain('42');
});

it('renders cell with align right', function () {
    $html = Blade::render('<x-aura::table.cell align="right">$99</x-aura::table.cell>');

    expect($html)->toContain('text-right');
});

it('merges custom attributes on table', function () {
    $html = Blade::render('<x-aura::table id="users-table"><x-aura::table.body><x-aura::table.row><x-aura::table.cell>A</x-aura::table.cell></x-aura::table.row></x-aura::table.body></x-aura::table>');

    expect($html)->toContain('id="users-table"');
});

it('merges custom attributes on row', function () {
    $html = Blade::render('<x-aura::table.row class="custom-row">content</x-aura::table.row>');

    expect($html)->toContain('custom-row');
});

it('renders head with correct classes', function () {
    $html = Blade::render('<x-aura::table.head><x-aura::table.row><x-aura::table.header>H</x-aura::table.header></x-aura::table.row></x-aura::table.head>');

    expect($html)
        ->toContain('aura-table-head')
        ->toContain('bg-aura-surface-50');
});

it('renders body with correct classes', function () {
    $html = Blade::render('<x-aura::table.body><x-aura::table.row><x-aura::table.cell>C</x-aura::table.cell></x-aura::table.row></x-aura::table.body>');

    expect($html)
        ->toContain('aura-table-body')
        ->toContain('divide-y');
});

it('combines multiple variants', function () {
    $html = Blade::render('<x-aura::table striped hoverable bordered compact><x-aura::table.body><x-aura::table.row><x-aura::table.cell>A</x-aura::table.cell></x-aura::table.row></x-aura::table.body></x-aura::table>');

    expect($html)
        ->toContain('aura-table-striped')
        ->toContain('aura-table-hoverable')
        ->toContain('aura-table-bordered')
        ->toContain('aura-table-compact');
});
