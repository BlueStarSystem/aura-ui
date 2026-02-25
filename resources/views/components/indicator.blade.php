@props([
    'position' => 'top-right',
    'color' => 'danger',
    'size' => 'md',
    'ping' => false,
    'label' => null,
])

@php
    $positionClass = match($position) {
        'top-left' => 'top-0 left-0 -translate-x-1/3 -translate-y-1/3',
        'bottom-right' => 'bottom-0 right-0 translate-x-1/3 translate-y-1/3',
        'bottom-left' => 'bottom-0 left-0 -translate-x-1/3 translate-y-1/3',
        default => 'top-0 right-0 translate-x-1/3 -translate-y-1/3',
    };

    $colorClass = match($color) {
        'primary' => 'bg-aura-primary-500 text-white',
        'success' => 'bg-aura-success-500 text-white',
        'warning' => 'bg-aura-warning-500 text-white',
        'info' => 'bg-aura-info-500 text-white',
        'secondary' => 'bg-aura-surface-400 text-white',
        default => 'bg-aura-danger-500 text-white',
    };

    $sizeClass = match($size) {
        'sm' => $label ? 'h-4 min-w-4 text-[10px] px-1' : 'h-2 w-2',
        'lg' => $label ? 'h-6 min-w-6 text-xs px-1.5' : 'h-4 w-4',
        default => $label ? 'h-5 min-w-5 text-[11px] px-1' : 'h-3 w-3',
    };

    $pingColorClass = match($color) {
        'primary' => 'bg-aura-primary-400',
        'success' => 'bg-aura-success-400',
        'warning' => 'bg-aura-warning-400',
        'info' => 'bg-aura-info-400',
        'secondary' => 'bg-aura-surface-300',
        default => 'bg-aura-danger-400',
    };
@endphp

<div {{ $attributes->class(['aura-indicator relative inline-flex']) }}>
    {{ $slot }}
    @if($ping)
        <span class="absolute {{ $positionClass }} flex items-center justify-center rounded-full {{ $sizeClass }} {{ $pingColorClass }} aura-animate-ping" style="animation:aura-ping 1s cubic-bezier(0,0,0.2,1) infinite"></span>
    @endif
    <span class="aura-indicator-badge absolute {{ $positionClass }} flex items-center justify-center rounded-full font-semibold {{ $colorClass }} {{ $sizeClass }} ring-2 ring-aura-surface-0">
        @if($label){{ $label }}@endif
    </span>
</div>
