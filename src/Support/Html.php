<?php

namespace BlueStarSystem\AuraUI\Support;

/**
 * Guards for the two places Blade's `{{ }}` is not enough.
 *
 * `{{ }}` runs htmlspecialchars, which escapes < > & " ' — and nothing else.
 * A space and an equals sign survive it, so interpolating an untrusted value
 * as a tag name or inside a style attribute is still injection:
 *
 *   <{{ $as }}>            with $as = 'div onmouseover=alert(1)'
 *   style="width: {{ $w }}" with $w  = '1px; background:url(//evil)'
 *
 * A component library cannot know whether the application validated the value
 * it passed, so the library validates it.
 */
final class Html
{
    /**
     * Tags a layout primitive may legitimately render as.
     *
     * @var list<string>
     */
    public const ALLOWED_TAGS = [
        'div', 'span', 'section', 'article', 'aside', 'nav',
        'header', 'footer', 'main', 'ul', 'ol', 'li', 'p', 'figure',
    ];

    /**
     * Resolve an `as` prop to a safe tag name, falling back rather than
     * rendering whatever arrived.
     */
    public static function tag(mixed $as, string $fallback = 'div'): string
    {
        return is_string($as) && in_array(strtolower($as), self::ALLOWED_TAGS, true)
            ? strtolower($as)
            : $fallback;
    }

    /**
     * Schemes a link may navigate to. `javascript:` and `data:` are the two
     * that turn a URL into code; `vbscript:` is the same idea, older.
     *
     * @var list<string>
     */
    public const ALLOWED_SCHEMES = ['http', 'https', 'mailto', 'tel', 'ftp', 'sms'];

    /**
     * Resolve an href to something safe to navigate to. Relative URLs,
     * fragments and query strings pass through untouched; anything carrying an
     * unknown scheme becomes '#', which is inert and visible rather than
     * silently dangerous.
     */
    public static function url(mixed $href, string $fallback = '#'): string
    {
        if (! is_string($href) || trim($href) === '') {
            return $fallback;
        }

        $href = trim($href);

        // No colon before the first /, ? or # means there is no scheme at all:
        // a relative path, a fragment or a query. Those are safe as they are.
        if (preg_match('#^[^/?\#]*:#', $href) !== 1) {
            return $href;
        }

        // A scheme is only a scheme if it matches the RFC 3986 shape. Anything
        // else with a colon in it (a path segment, say) was handled above.
        if (preg_match('#^([a-z][a-z0-9+.-]*):#i', $href, $found) !== 1) {
            return $fallback;
        }

        return in_array(strtolower($found[1]), self::ALLOWED_SCHEMES, true) ? $href : $fallback;
    }

    /**
     * A single CSS length, ratio or keyword — nothing that could close the
     * declaration and start another. Returns null when the value is not one,
     * so the caller can omit the attribute entirely.
     */
    public static function cssValue(mixed $value): ?string
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        // Digits, letters, dot, slash, percent, space and hyphen cover
        // `16/9`, `60vh`, `calc` is deliberately excluded: it brings
        // parentheses, and parentheses bring url().
        return preg_match('/^[0-9a-z.\/%\s-]+$/i', $value) === 1 ? $value : null;
    }
}
