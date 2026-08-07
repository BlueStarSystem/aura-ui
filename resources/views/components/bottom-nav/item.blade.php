@props([
    'href' => '#',
    'icon' => null,
    'label' => null,
    'active' => false,
    'badge' => null,
])

<a
    {{ $attributes->class([
        'aura-bottom-nav-item relative flex min-h-[3.25rem] flex-1 flex-col items-center justify-center gap-0.5 px-2 py-1.5 text-[11px] font-medium aura-transition-fast',
        $active ? 'aura-bottom-nav-active text-aura-primary-600 dark:text-aura-primary-400' : 'text-aura-surface-600 hover:text-aura-surface-900',
    ]) }}
    href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}"
    {{-- The colour alone says which page you are on, and colour alone is not
         enough — aria-current says it in words. --}}
    @if($active) aria-current="page" @endif
>
    @if($icon)
        <span class="aura-bottom-nav-icon relative">
            <x-aura::icon :name="$icon" size="md" aria-hidden="true" />

            @if($badge !== null && $badge !== '')
                <span class="aura-bottom-nav-badge absolute -right-2 -top-1 inline-flex min-w-[1.125rem] items-center justify-center rounded-full bg-aura-danger-600 px-1 text-[10px] font-bold text-white">{{ $badge }}</span>
            @endif
        </span>
    @endif

    @if($label)
        <span class="aura-bottom-nav-label">{{ $label }}</span>
    @endif

    {{ $slot }}
</a>
