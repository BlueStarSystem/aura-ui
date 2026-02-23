@props([
    'variant' => 'primary',
    'size' => 'md',
    'outline' => false,
    'gradient' => false,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconRight' => null,
    'iconOnly' => false,
    'href' => null,
    'type' => 'button',
])

@php
    // Treat variant="outline" as outline prop on primary
    if ($variant === 'outline') {
        $outline = true;
        $variant = 'primary';
    }

    $variantClasses = match($variant) {
        'primary' => 'bg-aura-primary-500 text-white hover:bg-aura-primary-600 focus-visible:shadow-[var(--aura-glow-primary)]',
        'secondary' => 'bg-aura-surface-100 text-aura-surface-900 border-aura-surface-300 hover:bg-aura-surface-200 hover:border-aura-surface-400 hover:shadow-aura-md focus-visible:shadow-[0_0_0_3px_rgba(100,116,139,0.2)]',
        'success' => 'bg-aura-success-500 text-white hover:bg-aura-success-600 focus-visible:shadow-[var(--aura-glow-success)]',
        'warning' => 'bg-aura-warning-500 text-aura-surface-900 hover:bg-aura-warning-600 focus-visible:shadow-[var(--aura-glow-warning)]',
        'danger' => 'bg-aura-danger-500 text-white hover:bg-aura-danger-600 focus-visible:shadow-[var(--aura-glow-danger)]',
        'ghost' => 'bg-transparent text-aura-surface-500 border-transparent hover:bg-aura-surface-100 hover:text-aura-surface-900 hover:shadow-none focus-visible:shadow-[0_0_0_3px_rgba(100,116,139,0.15)]',
        'link' => 'bg-transparent text-aura-primary-600 dark:text-aura-primary-400 border-transparent px-1 underline underline-offset-[3px] hover:text-aura-primary-700 dark:hover:text-aura-primary-300 hover:shadow-none',
        default => 'bg-aura-primary-500 text-white hover:bg-aura-primary-600',
    };

    // Override variant classes when outline mode is active
    if ($outline) {
        $variantClasses = match($variant) {
            'primary' => 'bg-transparent text-aura-primary-600 border-aura-primary-300 hover:bg-aura-primary-50 hover:border-aura-primary-500 focus-visible:shadow-[var(--aura-glow-primary)]',
            'secondary' => 'bg-transparent text-aura-surface-700 border-aura-surface-300 hover:bg-aura-surface-50 hover:border-aura-surface-400 focus-visible:shadow-[0_0_0_3px_rgba(100,116,139,0.2)]',
            'success' => 'bg-transparent text-aura-success-600 border-aura-success-300 hover:bg-aura-success-50 hover:border-aura-success-500 focus-visible:shadow-[var(--aura-glow-success)]',
            'warning' => 'bg-transparent text-aura-warning-600 border-aura-warning-300 hover:bg-aura-warning-50 hover:border-aura-warning-500 focus-visible:shadow-[var(--aura-glow-warning)]',
            'danger' => 'bg-transparent text-aura-danger-600 border-aura-danger-300 hover:bg-aura-danger-50 hover:border-aura-danger-500 focus-visible:shadow-[var(--aura-glow-danger)]',
            default => 'bg-transparent text-aura-primary-600 border-aura-primary-300 hover:bg-aura-primary-50 hover:border-aura-primary-500 focus-visible:shadow-[var(--aura-glow-primary)]',
        };
    }

    $sizeClasses = match($size) {
        'xs' => 'aura-btn-xs py-1 px-2.5 text-xs gap-1 rounded-aura-sm',
        'sm' => 'aura-btn-sm py-1.5 px-3.5 text-[13px] gap-1.5',
        'lg' => 'aura-btn-lg py-3 px-6 text-[15px] gap-2.5 rounded-aura-lg',
        'xl' => 'aura-btn-xl py-4 px-8 text-base gap-2.5 rounded-aura-lg',
        default => 'py-2.5 px-5 text-sm gap-2',
    };

    $iconSizeClasses = match($size) {
        'xs' => '[&_svg]:w-3 [&_svg]:h-3',
        'sm' => '[&_svg]:w-3.5 [&_svg]:h-3.5',
        'lg' => '[&_svg]:w-[18px] [&_svg]:h-[18px]',
        'xl' => '[&_svg]:w-5 [&_svg]:h-5',
        default => '[&_svg]:w-4 [&_svg]:h-4',
    };

    $classes = [
        'aura-btn',
        "aura-btn-{$variant}",
        "aura-btn-{$size}",
        'inline-flex items-center justify-center font-[inherit] font-medium leading-none border border-transparent rounded-aura-md cursor-pointer select-none whitespace-nowrap no-underline aura-transition relative overflow-hidden',
        'hover:shadow-aura-lg',
        'active:shadow-aura-xs',
        'focus-visible:outline-none',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        $variantClasses,
        $sizeClasses,
        $iconSizeClasses,
        '[&_svg]:shrink-0',
    ];

    if ($outline) $classes[] = 'aura-btn-outline border-[1.5px]';
    if ($gradient) $classes[] = 'aura-btn-gradient border-none';
    if ($loading) $classes[] = 'aura-btn-loading';
    if ($iconOnly) $classes[] = 'aura-btn-icon-only';

    $isDisabled = $disabled || $loading;
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->class($classes) }} @if($isDisabled) aria-disabled="true" tabindex="-1" @endif>
    @if($loading)
        <span class="aura-btn-spinner"></span>
    @elseif($icon)
        <x-aura::icon :name="$icon" size="sm" />
    @endif
    <span class="inline-flex items-center gap-[inherit]">{{ $slot }}</span>
    @if($iconRight)
        <x-aura::icon :name="$iconRight" size="sm" />
    @endif
</a>
@else
<button type="{{ $type }}" {{ $attributes->class($classes) }} @if($isDisabled) disabled @endif>
    @if($loading)
        <span class="aura-btn-spinner"></span>
    @elseif($icon)
        <x-aura::icon :name="$icon" size="sm" />
    @endif
    <span class="inline-flex items-center gap-[inherit]">{{ $slot }}</span>
    @if($iconRight)
        <x-aura::icon :name="$iconRight" size="sm" />
    @endif
</button>
@endif
