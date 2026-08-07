<?php

use BlueStarSystem\AuraUI\Support\Html;
use Illuminate\Support\Facades\Blade;

describe('url', function () {
    it('lets ordinary links through untouched', function (string $href) {
        expect(Html::url($href))->toBe($href);
    })->with([
        'https://example.com/docs',
        'http://example.com',
        'mailto:info@example.com',
        'tel:+390000000',
        '/docs/components/button',
        '#section',
        '?page=2',
        'relative/path.html',
        'a/path:with/a/colon',
    ]);

    it('refuses a scheme that executes', function (string $href) {
        expect(Html::url($href))->toBe('#');
    })->with([
        'javascript:alert(1)',
        'JavaScript:alert(1)',
        '  javascript:alert(1)',
        'jAvAsCrIpT:alert(document.cookie)',
        'data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==',
        'vbscript:msgbox(1)',
        'file:///etc/passwd',
    ]);

    it('refuses anything that is not a string, or is empty', function (mixed $href) {
        expect(Html::url($href))->toBe('#');
        // An array dataset entry is spread as arguments, so [] would mean "no
        // argument at all" rather than "an array" — covered below instead.
    })->with([null, '', '   ', 42, true]);

    it('refuses an array', function () {
        expect(Html::url(['https://example.com']))->toBe('#');
    });

    it('does not let a link component render an executable scheme', function () {
        $html = Blade::render('<x-aura::link href="javascript:alert(1)">Click</x-aura::link>');

        expect($html)
            ->not->toContain('javascript:')
            ->toContain('href="#"');
    });
});

describe('tag', function () {
    it('accepts the tags a layout primitive legitimately renders as', function () {
        expect(Html::tag('section'))->toBe('section');
        expect(Html::tag('UL'))->toBe('ul');
    });

    it('falls back rather than rendering an injected attribute', function (mixed $as) {
        expect(Html::tag($as))->toBe('div');
    })->with([
        'div onmouseover=alert(1)',
        'script',
        'img src=x onerror=alert(1)',
        '',
        null,
        123,
    ]);

    it('honours a component-specific fallback', function () {
        expect(Html::tag('script', 'span'))->toBe('span');
    });

    /**
     * htmlspecialchars escapes < > & " ' — a space and an equals sign go
     * straight through, which is why interpolating a tag name was injectable
     * even though Blade "escaped" it.
     */
    it('does not let a stack render an injected handler', function () {
        $html = Blade::render('<x-aura::stack as="div onmouseover=alert(1)">x</x-aura::stack>');

        expect($html)->not->toContain('onmouseover');
    });
});

describe('cssValue', function () {
    it('accepts lengths, ratios and keywords', function (string $value) {
        expect(Html::cssValue($value))->toBe($value);
    })->with(['16/9', '1/1', '60vh', '20rem', '100%', '320px', 'auto', '#ef4444', '#fff', 'rebeccapurple']);

    it('rejects anything that could start a second declaration', function (mixed $value) {
        expect(Html::cssValue($value))->toBeNull();
    })->with([
        '1px; background:url(//evil.test/x)',
        'url(//evil.test)',
        'calc(100% - 1px)',
        'expression(alert(1))',
        '',
        null,
    ]);

    it('keeps a hostile ratio out of the rendered style attribute', function () {
        $html = Blade::render('<x-aura::aspect-ratio ratio="1; background:url(//evil.test)">x</x-aura::aspect-ratio>');

        expect($html)
            ->not->toContain('evil.test')
            ->toContain('aspect-ratio: 16/9');
    });
});

describe('href in components that build the attribute by hand', function () {
    /**
     * data-card and notification-center.item assemble `href="..."` as a string
     * and print it with {!! !!}. e() stopped the value escaping the attribute
     * but said nothing about the scheme, and both of these usually carry a URL
     * from the database.
     */
    it('drops an executable scheme instead of linking to it', function (string $markup) {
        $html = Blade::render($markup);

        expect($html)
            ->not->toContain('javascript:')
            ->not->toContain('href=');
    })->with([
        '<x-aura::data-card title="T" value="1" href="javascript:alert(1)" />',
        '<x-aura::notification-center.item title="T" url="javascript:alert(1)" />',
    ]);

    it('still links to a legitimate URL', function (string $markup, string $expected) {
        expect(Blade::render($markup))->toContain($expected);
    })->with([
        ['<x-aura::data-card title="T" value="1" href="/orders/42" />', 'href="/orders/42"'],
        ['<x-aura::notification-center.item title="T" url="https://example.com/n/1" />', 'href="https://example.com/n/1"'],
    ]);
});

it('lets an image use a data URI while an href still cannot', function () {
    // Different threat models: a data: href navigates and can run script; a
    // data: image cannot — browsers refuse to run script in an SVG loaded
    // through <img>.
    $uri = 'data:image/svg+xml,%3Csvg%3E%3C/svg%3E';

    expect(\BlueStarSystem\AuraUI\Support\Html::src($uri))->toBe($uri);
    expect(\BlueStarSystem\AuraUI\Support\Html::url($uri))->toBe('#');
});

it('narrows a data src to images only', function () {
    expect(\BlueStarSystem\AuraUI\Support\Html::src('data:text/html,<script>alert(1)</script>'))->toBe('');
    expect(\BlueStarSystem\AuraUI\Support\Html::src('javascript:alert(1)'))->toBe('');
    expect(\BlueStarSystem\AuraUI\Support\Html::src('/local/photo.jpg'))->toBe('/local/photo.jpg');
});
