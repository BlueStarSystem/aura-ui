@props([
    'title' => null,
    'description' => null,
    'level' => 2,
    'spacing' => 'md',
])

@php
    $spacingClass = match($spacing) {
        'none' => 'py-0',
        'sm' => 'py-6',
        'lg' => 'py-16',
        'xl' => 'py-24',
        default => 'py-10',
    };

    // Derived from the title, not random: a random id changes on every render,
    // which defeats view caching and makes any snapshot unstable.
    $headingId = $title
        ? 'aura-section-'.\Illuminate\Support\Str::slug((string) $title)
        : null;
@endphp

{{--
    A real <section>. It is only a landmark when it has an accessible name, so
    passing `title` also wires aria-labelledby — a <section> without a name is
    announced as a plain group, which is usually what an unnamed one deserves.
--}}
<section
    {{ $attributes->class(['aura-section', $spacingClass]) }}
    @if($headingId) aria-labelledby="{{ $headingId }}" @endif
>
    @if($title || $description)
        <div class="aura-section-header mb-6">
            @if($title)
                <x-aura::heading :level="$level" :id="$headingId">{{ $title }}</x-aura::heading>
            @endif

            @if($description)
                <x-aura::text color="muted" class="mt-1">{{ $description }}</x-aura::text>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
