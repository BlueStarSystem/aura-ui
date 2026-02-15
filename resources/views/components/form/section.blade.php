@props([
    'title' => null,
    'description' => null,
    'columns' => 1,
    'aside' => false,
])

@php
    $gridClass = match((int)$columns) {
        2 => 'aura-form-grid-2',
        3 => 'aura-form-grid-3',
        default => 'aura-form-grid-1',
    };
@endphp

<div {{ $attributes->class(['aura-form-section', $aside ? 'aura-form-section-aside' : '']) }}>
    @if($title || $description)
        <div class="aura-form-section-header">
            @if($title)
                <h3 class="aura-form-section-title">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="aura-form-section-description">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="aura-form-section-content {{ $gridClass }}">
        {{ $slot }}
    </div>
</div>
