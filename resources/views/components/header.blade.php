@props([
    'title' => '',
    'description' => null,
    'size' => 'md',
])

@php
    $titleClass = match($size) {
        'sm' => 'text-lg',
        'lg' => 'text-2xl',
        'xl' => 'text-3xl',
        default => 'text-xl',
    };
@endphp

<div {{ $attributes->class(['aura-header flex items-start justify-between gap-4 pb-4 border-b border-aura-surface-200']) }}>
    <div class="aura-header-content flex-1 min-w-0">
        <h2 class="aura-header-title font-semibold text-aura-surface-900 tracking-tight {{ $titleClass }}">{{ $title }}</h2>
        @if($description)
            <p class="aura-header-description mt-1 text-sm text-aura-surface-500 leading-relaxed">{{ $description }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div class="aura-header-actions flex items-center gap-2 shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>
