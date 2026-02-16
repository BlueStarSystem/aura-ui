@props([
    'title' => null,
    'description' => null,
    'columns' => 1,
    'aside' => false,
])

@php
    $gridClass = match((int)$columns) {
        2 => 'aura-form-grid-2 grid grid-cols-2 gap-4',
        3 => 'aura-form-grid-3 grid grid-cols-3 gap-4',
        default => 'aura-form-grid-1 flex flex-col gap-4',
    };
@endphp

<div {{ $attributes->class(['aura-form-section', 'border-b border-aura-surface-200 pb-6 last:border-b-0 last:pb-0', $aside ? 'aura-form-section-aside grid grid-cols-[1fr_2fr] gap-x-8 gap-y-6' : '']) }}>
    @if($title || $description)
        <div class="aura-form-section-header">
            @if($title)
                <h3 class="aura-form-section-title text-[15px] font-semibold text-aura-surface-900 m-0">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="aura-form-section-description text-[13px] text-aura-surface-500 mt-1 mb-0 leading-normal">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="aura-form-section-content {{ $gridClass }}">
        {{ $slot }}
    </div>
</div>
