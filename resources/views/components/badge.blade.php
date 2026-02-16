@props([
    'variant' => 'primary',
    'size' => 'md',
    'dot' => false,
    'icon' => null,
    'removable' => false,
    'outline' => false,
    'gradient' => false,
    'rounded' => false,
])

@php
    $variantClasses = match($variant) {
        'primary' => 'bg-aura-primary-100 text-aura-primary-700 dark:bg-[rgba(129,140,248,0.15)] dark:text-aura-primary-300',
        'secondary' => 'bg-aura-surface-200 text-aura-surface-500 dark:text-aura-surface-600',
        'success' => 'bg-aura-success-100 text-aura-success-700 dark:bg-[rgba(52,211,153,0.15)] dark:text-aura-success-300',
        'warning' => 'bg-aura-warning-100 text-aura-warning-700 dark:bg-[rgba(251,191,36,0.15)] dark:text-aura-warning-300',
        'danger' => 'bg-aura-danger-100 text-aura-danger-700 dark:bg-[rgba(248,113,113,0.15)] dark:text-aura-danger-300',
        'info' => 'bg-aura-info-100 text-aura-info-700 dark:bg-[rgba(56,189,248,0.15)] dark:text-aura-info-300',
        default => 'bg-aura-primary-100 text-aura-primary-700',
    };

    $sizeClasses = match($size) {
        'sm' => 'aura-badge-sm px-1.5 py-px text-[11px] gap-1',
        'lg' => 'px-3.5 py-1.5 text-[13px] gap-1.5',
        default => 'px-2.5 py-0.5 text-xs gap-1.5',
    };

    $classes = [
        'aura-badge',
        "aura-badge-{$variant}",
        "aura-badge-{$size}",
        'inline-flex items-center font-semibold leading-snug whitespace-nowrap rounded-aura-sm aura-transition',
        $variantClasses,
        $sizeClasses,
    ];

    if ($outline) $classes[] = 'aura-badge-outline bg-transparent border-[1.5px] border-current';
    if ($gradient) $classes[] = 'aura-badge-gradient';
    if ($rounded) $classes[] = 'aura-badge-pill rounded-aura-full';
    if ($dot) $classes[] = 'aura-badge-dot';
@endphp

<span {{ $attributes->class($classes) }}>
    @if($dot)
        <span class="aura-badge-dot"></span>
    @endif
    @if($icon)
        <x-aura::icon :name="$icon" size="xs" />
    @endif
    {{ $slot }}
    @if($removable)
        <button type="button" class="aura-badge-remove" aria-label="Remove">
            <x-aura::icon name="x" size="xs" />
        </button>
    @endif
</span>
