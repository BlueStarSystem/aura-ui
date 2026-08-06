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
        'enabled' => env('AURA_PLAYGROUND', false),
        'path' => 'aura/playground',
        'middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Remote Registry
    |--------------------------------------------------------------------------
    |
    | Configuration for the RemoteRegistry (aura add <url>) secure fetch.
    | allowed_hosts: hosts that do NOT require interactive confirmation.
    | max_bytes: maximum response body size accepted from the registry.
    |
    */
    'registry' => [
        'allowed_hosts' => ['aura-ui.com'],
        'max_bytes' => 512 * 1024,
    ],
    /*
    |--------------------------------------------------------------------------
    | Chart.js
    |--------------------------------------------------------------------------
    |
    | Where the chart component loads Chart.js from when the page has not
    | already loaded it. The default is the CDN because it is the only source
    | that exists in a fresh install: the component used to try a local
    | '/js/vendor/chart.umd.min.js' first, which no application ships, so every
    | chart logged a 404 and a blocked-script error before falling back here.
    |
    | To self-host, put the UMD build under public/ and point this at it.
    |
    */
    'chart' => [
        'src' => env('AURA_CHART_SRC', 'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js'),
    ],
];