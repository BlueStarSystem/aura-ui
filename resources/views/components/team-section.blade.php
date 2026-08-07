@props([
    'title' => null,
    'description' => null,
    'columns' => 3,
])

@php
    $sectionId = 'aura-team-'.\Illuminate\Support\Str::random(8);

    // Written out: an interpolated grid-cols-{$n} is a class Tailwind never
    // sees whole, so no rule is generated and the grid collapses to one column.
    $columnClass = match ((int) $columns) {
        2 => 'sm:grid-cols-2',
        4 => 'sm:grid-cols-2 lg:grid-cols-4',
        default => 'sm:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section
    {{ $attributes->class(['aura-team-section']) }}
    @if($title) aria-labelledby="{{ $sectionId }}-title" @endif
>
    @if($title || $description)
        <div class="aura-team-head mx-auto max-w-2xl text-center">
            @if($title)
                <h2 id="{{ $sectionId }}-title" class="aura-team-title text-2xl font-bold text-aura-surface-900">{{ $title }}</h2>
            @endif

            @if($description)
                <p class="aura-team-description mt-2 text-aura-surface-600">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{-- A list, so a screen reader announces how many people are in the team
         before reading them out one by one. --}}
    <ul class="aura-team-members mt-10 grid grid-cols-1 gap-8 {{ $columnClass }}">
        {{ $slot }}
    </ul>
</section>
