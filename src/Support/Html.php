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
     * A stable id for a form control.
     *
     * The components used `uniqid()`, which produces a different id on every
     * render. Livewire re-renders on a new request, so the label's `for` and
     * the input's `id` were being rewritten under the user on each round trip,
     * and any `aria-describedby` pointing at the error text went with them.
     *
     * Derived from the id, then the name, then the label: an input with none
     * of the three is already unusable, and only then do we fall back to
     * something generated.
     */
    public static function fieldId(mixed $id, mixed $name = null, mixed $label = null): string
    {
        foreach ([$id, $name] as $candidate) {
            if (is_string($candidate) && trim($candidate) !== '') {
                // A name like `contact[email]` is not a valid id fragment.
                return trim(preg_replace('/[^A-Za-z0-9_-]+/', '-', trim($candidate)) ?? '', '-');
            }
        }

        if (is_string($label) && trim($label) !== '') {
            return 'aura-field-'.substr(md5(trim($label)), 0, 8);
        }

        return 'aura-field-'.substr(md5(uniqid('', true)), 0, 8);
    }

    /**
     * Merge an id into an existing aria-describedby rather than replacing it.
     *
     * The components emitted their own `aria-describedby` while the attribute
     * bag also rendered whatever the consumer passed, leaving two of the same
     * attribute on one element — browsers keep the first and drop the help
     * text the application deliberately attached.
     */
    public static function describedBy(mixed $existing, ?string ...$ids): ?string
    {
        $parts = [];

        if (is_string($existing) && trim($existing) !== '') {
            $parts = preg_split('/\s+/', trim($existing)) ?: [];
        }

        foreach ($ids as $id) {
            if (is_string($id) && trim($id) !== '') {
                $parts[] = trim($id);
            }
        }

        $parts = array_values(array_unique(array_filter($parts)));

        return $parts === [] ? null : implode(' ', $parts);
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
