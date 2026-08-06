@props([
    'query' => null,
    'text' => null,
    'color' => 'warning',
    'caseSensitive' => false,
    'wholeWord' => false,
])

@php
    /**
     * Marks every occurrence of `query` inside `text` — search results, a
     * filtered list, a log viewer. `mark` is its manual counterpart: there you
     * wrap the words yourself.
     *
     * The subject is escaped BEFORE any marker goes in, and the marker is the
     * only HTML added afterwards. Escaping last would let a caller's text close
     * the tag and inject markup; escaping first cannot.
     */
    $subject = $text ?? $slot->toHtml();
    $terms = array_filter(array_map('trim', is_array($query) ? $query : [$query]), fn ($t) => $t !== null && $t !== '');

    $escaped = e($subject);

    if ($terms !== []) {
        $pattern = implode('|', array_map(
            // The needle is escaped the same way, so it matches the escaped
            // subject: searching for "R&D" has to find "R&amp;D".
            fn (string $term): string => preg_quote(e($term), '/'),
            $terms
        ));

        if ($wholeWord) {
            $pattern = '\b(?:'.$pattern.')\b';
        }

        // The same pairs the mark component uses, and the same ones the
        // contrast suite asserts.
        $markClass = 'aura-highlight-mark aura-mark rounded px-1 '.match ($color) {
            'primary' => 'bg-aura-primary-100 text-aura-primary-900',
            'success' => 'bg-aura-success-100 text-aura-success-900',
            'danger' => 'bg-aura-danger-100 text-aura-danger-900',
            'info' => 'bg-aura-info-100 text-aura-info-900',
            default => 'bg-aura-warning-100 text-aura-warning-900',
        };

        $escaped = preg_replace(
            '/('.$pattern.')/'.($caseSensitive ? 'u' : 'iu'),
            '<mark class="'.$markClass.'">$1</mark>',
            $escaped
        ) ?? $escaped;
    }
@endphp

<span {{ $attributes->class(['aura-highlight']) }}>{!! $escaped !!}</span>
