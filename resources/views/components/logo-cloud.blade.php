@props([
    'title' => null,
    'columns' => 5,
    'grayscale' => true,
])

@php
    /**
     * The row of customer logos under a hero.
     *
     * Column counts are written out: Tailwind reads source files as text and
     * generates nothing for `lg:grid-cols-{$columns}`, so an interpolated
     * class collapses the row into a single column, silently.
     */
    $cloudId = 'aura-logo-cloud-'.\Illuminate\Support\Str::random(8);

    $columnClass = match ((int) $columns) {
        3 => 'grid-cols-2 sm:grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-4',
        6 => 'grid-cols-3 sm:grid-cols-6',
        default => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-5',
    };
@endphp

<section
    {{ $attributes->class(['aura-logo-cloud']) }}
    @if($title) aria-labelledby="{{ $cloudId }}-title" @endif
>
    @if($title)
        <h2 id="{{ $cloudId }}-title" class="aura-logo-cloud-title text-center text-sm font-medium text-aura-surface-600">{{ $title }}</h2>
    @endif

    <ul class="aura-logo-cloud-items mt-6 grid items-center gap-x-8 gap-y-6 {{ $columnClass }} {{ $grayscale ? 'aura-logo-cloud-grayscale' : '' }}">
        {{ $slot }}
    </ul>
</section>
