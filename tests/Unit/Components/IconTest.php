<?php

use Illuminate\Support\Facades\Blade;

/**
 * An unknown icon name falls back to a plain circle, silently: no exception,
 * no warning. That makes broken aliases invisible until someone looks at the
 * page — which is exactly how 19 aliases pointing at never-drawn icons
 * (euro, flame, banknote, ...) survived in the map.
 */
function fallbackCircle(): string
{
    return trim(Blade::render('<x-aura::icon name="__definitely-not-an-icon__" />'));
}

function iconRenders(string $name): bool
{
    return trim(Blade::render('<x-aura::icon name="'.$name.'" />')) !== fallbackCircle();
}

/** @return array{icons: list<string>, aliases: array<string, string>} */
function iconMap(): array
{
    $src = file_get_contents(__DIR__.'/../../../resources/views/components/icon.blade.php');
    $icons = [];
    $aliases = [];

    if (preg_match('/\$icons\s*=\s*\[(.*?)\n    \];/s', $src, $m)) {
        preg_match_all("/'([a-z0-9-]+)'\s*=>\s*'([^']*)'/", $m[1], $rows, PREG_SET_ORDER);
        foreach ($rows as $row) {
            str_contains($row[2], '<') ? $icons[] = $row[1] : $aliases[$row[1]] = $row[2];
        }
    }

    if (preg_match('/\$heroiconMap\s*=\s*\[(.*?)\n    \];/s', $src, $m)) {
        preg_match_all("/'([a-z0-9-]+)'\s*=>\s*'([a-z0-9-]+)'/", $m[1], $rows, PREG_SET_ORDER);
        foreach ($rows as $row) {
            $aliases[$row[1]] = $row[2];
        }
    }

    return ['icons' => $icons, 'aliases' => $aliases];
}

it('renders a known icon', function () {
    expect(iconRenders('home'))->toBeTrue();
});

it('falls back to a circle for an unknown name', function () {
    $html = Blade::render('<x-aura::icon name="__definitely-not-an-icon__" />');

    expect($html)->toContain('<circle');
});

it('has no alias pointing at an icon that does not exist', function () {
    ['icons' => $icons, 'aliases' => $aliases] = iconMap();

    $broken = [];
    foreach ($aliases as $alias => $target) {
        if (! in_array($target, $icons, true) && ! isset($aliases[$target])) {
            $broken[] = "$alias -> $target";
        }
    }

    expect($broken)->toBe([], 'These aliases resolve to nothing and render the fallback circle: '.implode(', ', $broken));
});

it('renders every aliased name, not just the ones in $icons', function () {
    ['aliases' => $aliases] = iconMap();

    $broken = array_values(array_filter(
        array_keys($aliases),
        fn (string $alias) => ! iconRenders($alias)
    ));

    expect($broken)->toBe([], 'These names render the fallback circle: '.implode(', ', $broken));
});

it('draws the euro sign, not only the dollar one', function () {
    // A design system used by Italian apps needs it; it was missing while
    // dollar-sign and currency-dollar were both present.
    expect(iconRenders('euro'))->toBeTrue();
    expect(iconRenders('currency-euro'))->toBeTrue();
});
