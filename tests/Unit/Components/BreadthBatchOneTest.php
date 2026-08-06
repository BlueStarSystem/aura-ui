<?php

use Illuminate\Support\Facades\Blade;

/**
 * The seven primitives added on 2026-08-06 to close the breadth gap.
 * code-block came first because the shipped code.blade.php already told
 * people to use <x-aura::code-block>, which did not exist.
 */
it('renders a code block with its language, filename and copy control', function () {
    $html = Blade::render('<x-aura::code-block language="php" filename="app/Models/User.php">echo 1;</x-aura::code-block>');

    expect($html)
        ->toContain('aura-code-block')
        ->toContain('app/Models/User.php')
        ->toContain('language-php')
        ->toContain('aura-code-block-copy')
        ->toContain('echo 1;');
});

it('announces a completed copy instead of only showing a tick', function () {
    $html = Blade::render('<x-aura::code-block>echo 1;</x-aura::code-block>');

    expect($html)
        ->toContain('role="status"')
        ->toContain('aria-live="polite"');
});

it('strips the common indentation so the copied snippet is not indented', function () {
    $html = Blade::render(<<<'BLADE'
        <x-aura::code-block>
            $user = User::find(1);
            $user->save();
        </x-aura::code-block>
    BLADE);

    // The snippet keeps its own relative indentation but loses the block's.
    expect($html)
        ->toContain('$user = User::find(1);')
        ->not->toContain('            $user = User::find(1);');
});

it('leaves the code block out of the header when there is nothing to put in it', function () {
    $html = Blade::render('<x-aura::code-block :copyable="false">echo 1;</x-aura::code-block>');

    expect($html)->not->toContain('aura-code-block-header');
});

it('marks every occurrence of the query', function () {
    $html = Blade::render('<x-aura::highlight query="lo" text="Hello world, hello again" />');

    expect(substr_count($html, '<mark'))->toBe(2);
});

it('escapes the subject before it inserts any marker', function () {
    // Escaping last would let the text close the mark and inject markup;
    // escaping first cannot.
    $html = Blade::render('<x-aura::highlight query="x" text="<script>alert(1)</script> x" />');

    expect($html)
        ->not->toContain('<script>')
        ->toContain('&lt;script&gt;')
        ->toContain('<mark');
});

it('escapes the query too, so a regex in it cannot run', function () {
    $html = Blade::render('<x-aura::highlight query=".*" text="literal .* here" />');

    // A raw .* would have marked the whole string.
    expect(substr_count($html, '<mark'))->toBe(1);
});

it('finds a term whose escaped form differs from its raw form', function () {
    $html = Blade::render('<x-aura::highlight query="R&D" text="the R&D budget" />');

    expect($html)->toContain('<mark');
});

it('matches whole words only when asked', function () {
    $loose = Blade::render('<x-aura::highlight query="art" text="art cartoon" />');
    $strict = Blade::render('<x-aura::highlight query="art" text="art cartoon" whole-word />');

    expect(substr_count($loose, '<mark'))->toBe(2);
    expect(substr_count($strict, '<mark'))->toBe(1);
});

it('renders a callout with an icon that is not announced twice', function () {
    $html = Blade::render('<x-aura::callout variant="warning" title="Careful">Body</x-aura::callout>');

    expect($html)
        ->toContain('aura-callout-warning')
        ->toContain('Careful')
        ->toContain('aria-hidden="true"');
});

it('names an icon-only clipboard button', function () {
    $html = Blade::render('<x-aura::clipboard-button text="abc" icon-only />');

    expect($html)
        ->toContain('aria-label')
        ->toContain('role="status"');
});

it('builds the segmented control out of real radios', function () {
    $html = Blade::render('<x-aura::segmented-control label="View" :options="[\'list\', \'grid\']" />');

    expect($html)
        ->toContain('role="radiogroup"')
        ->toContain('type="radio"')
        ->toMatch('/aria-labelledby="(aura-segmented-[^"]+)-label"[\s\S]+id="\1-label"/');
});

it('makes a scroll area reachable by keyboard', function () {
    // A scrollable region nobody can focus cannot be scrolled without a
    // pointer — WCAG 2.1.1.
    $html = Blade::render('<x-aura::scroll-area label="Log">lines</x-aura::scroll-area>');

    expect($html)
        ->toContain('tabindex="0"')
        ->toContain('role="region"')
        ->toContain('aria-label="Log"');
});

it('names a scroll area that was given no label', function () {
    expect(Blade::render('<x-aura::scroll-area>x</x-aura::scroll-area>'))
        ->toContain('aria-label="Scrollable region"');
});

it('keeps the sticky panel offset out of reach of a style injection', function () {
    $html = Blade::render('<x-aura::sticky-panel offset="2rem">x</x-aura::sticky-panel>');
    expect($html)->toContain('top: 2rem');

    $hostile = Blade::render('<x-aura::sticky-panel offset="1rem; background: url(evil)">x</x-aura::sticky-panel>');
    expect($hostile)->not->toContain('url(');
});
