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
     * Whether a slot is empty in the way a template author means it.
     *
     * `ComponentSlot::isEmpty()` trims and compares, which is right until
     * Livewire is involved: it wraps every @if and @forelse in
     * `<!--[if BLOCK]><![endif]-->` markers, and trim() does not remove a
     * comment. A slot holding nothing but those markers therefore reports as
     * full, and any component choosing an empty state from isEmpty() silently
     * stops offering one.
     *
     * Reported by the BeautyFlow instance after their notification list stayed
     * blank instead of showing its empty state.
     */
    public static function slotIsEmpty(mixed $slot): bool
    {
        if ($slot === null) {
            return true;
        }

        $html = is_object($slot) && method_exists($slot, 'toHtml') ? $slot->toHtml() : (string) $slot;

        return trim((string) preg_replace('/<!--.*?-->/s', '', $html)) === '';
    }

    /**
     * A stable id for a form control.
     *
     * The components used `uniqid()`, which produces a different id on every
     * render. Livewire re-renders on a new request, so the label's `for` and
     * the input's `id` were being rewritten under the user on each round trip,
     * and any `aria-describedby` pointing at the error text went with them.
     *
     * Derived from the id, then the name, then wire:model, then the label.
     *
     * wire:model was added on the BeautyFlow instance's report: a Livewire app
     * often has no id, no name and no label on the component itself — the label
     * is a separate element and there is no HTML submit to need a name — and
     * 45 of their 194 fields fell through to the generated branch, which was
     * still random per render. The property a field is bound to is stable by
     * definition.
     *
     * @param  mixed  $wireModel  the wire:model value, if the caller has one
     */
    public static function fieldId(mixed $id, mixed $name = null, mixed $label = null, mixed $wireModel = null): string
    {
        foreach ([$id, $name] as $candidate) {
            if (is_string($candidate) && trim($candidate) !== '') {
                // A name like `contact[email]` is not a valid id fragment.
                return self::slugForId(trim($candidate));
            }
        }

        if (is_string($wireModel) && trim($wireModel) !== '') {
            // Prefixed on purpose: deriving straight from the property would
            // collide with a hand-written id="bookingColor" elsewhere on the
            // page, and two elements sharing an id break `for` and
            // aria-describedby for both.
            return 'aura-'.self::slugForId(trim($wireModel));
        }

        if (is_string($label) && trim($label) !== '') {
            return 'aura-field-'.substr(md5(trim($label)), 0, 8);
        }

        return 'aura-field-'.substr(md5(uniqid('', true)), 0, 8);
    }

    /**
     * Pull the bound property out of an attribute bag: wire:model and every
     * modifier of it (.live, .blur, .debounce.500ms …).
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function wireModelFrom(array $attributes): ?string
    {
        foreach ($attributes as $key => $value) {
            if (($key === 'wire:model' || str_starts_with((string) $key, 'wire:model.')) && is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return null;
    }

    private static function slugForId(string $value): string
    {
        return trim((string) preg_replace('/[^A-Za-z0-9_-]+/', '-', $value), '-');
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
     * Where an image may come from.
     *
     * A src and an href have different threat models. `data:` as an href is an
     * XSS vector — the browser navigates to it and runs what it finds. As an
     * image source it is not: browsers refuse to run script in an SVG loaded
     * through <img>, and any other media type simply fails to decode. Inline
     * placeholders and small avatars are a real need, so images get their own
     * list rather than being forced through the navigation one.
     *
     * @var list<string>
     */
    public const ALLOWED_SRC_SCHEMES = ['http', 'https', 'data', 'blob'];

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
     * The same treatment for an image source, with `data:` and `blob:`
     * permitted — and `data:` narrowed to images, so a data URI carrying
     * anything else never reaches the attribute.
     */
    public static function src(mixed $src, string $fallback = ''): string
    {
        if (! is_string($src) || trim($src) === '') {
            return $fallback;
        }

        $src = trim($src);

        if (preg_match('#^[^/?\#]*:#', $src) !== 1) {
            return $src;
        }

        if (preg_match('#^([a-z][a-z0-9+.-]*):#i', $src, $found) !== 1) {
            return $fallback;
        }

        $scheme = strtolower($found[1]);

        if (! in_array($scheme, self::ALLOWED_SRC_SCHEMES, true)) {
            return $fallback;
        }

        if ($scheme === 'data' && preg_match('#^data:image/[a-z0-9.+-]+[;,]#i', $src) !== 1) {
            return $fallback;
        }

        return $src;
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

        // Digits, letters, dot, slash, percent, hash, comma, space and hyphen
        // cover `16/9`, `60vh`, `#ef4444` and `auto`. None of them can end a
        // declaration or open a function call.
        //
        // Parentheses are excluded on purpose, which also rules out `calc()`,
        // `rgb()` and `var()`: they are the doorway `url()` comes through, and
        // a component prop is not where those belong.
        return preg_match('/^[0-9a-z.\/%#,\s-]+$/i', $value) === 1 ? $value : null;
    }
}
