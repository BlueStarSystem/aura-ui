<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Component Prefix
    |--------------------------------------------------------------------------
    |
    | All Aura UI components are prefixed with this value.
    | Usage: <x-aura::button>, <x-aura::input>, etc.
    |
    */
    'prefix' => 'aura',

    /*
    |--------------------------------------------------------------------------
    | Dark Mode
    |--------------------------------------------------------------------------
    |
    | How dark mode is detected. Options:
    | - 'class': Dark mode via .dark class on <html> (Tailwind default)
    | - 'media': Dark mode via prefers-color-scheme media query
    |
    */
    'dark_mode' => 'class',

    /*
    |--------------------------------------------------------------------------
    | Default Icon Set
    |--------------------------------------------------------------------------
    |
    | The icon set used by Aura components.
    | Requires blade-ui-kit/blade-heroicons or compatible package.
    |
    */
    'icons' => 'heroicon',

    /*
    |--------------------------------------------------------------------------
    | Playground
    |--------------------------------------------------------------------------
    |
    | Enable the component playground route at /aura/playground.
    | Only available when app.debug is true.
    |
    */
    'playground' => [
        'enabled' => true,
        'path' => 'aura/playground',
        'middleware' => ['web'],
    ],
];
