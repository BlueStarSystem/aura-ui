@props([
    'href' => '#',
    'external' => false,
])

<li class="aura-footer-link-item">
    <a
        {{ $attributes->class(['aura-footer-link text-sm text-aura-surface-600 aura-transition-fast hover:text-aura-surface-900']) }}
        href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}"
        @if($external) target="_blank" rel="noopener noreferrer" @endif
    >
        {{ $slot }}

        @if($external)
            {{-- Said out loud rather than shown: a new tab that opens without
                 warning is disorienting when you cannot see it happen. --}}
            <span class="aura-visually-hidden">({{ __('aura-ui::messages.opens_in_new_tab') }})</span>
        @endif
    </a>
</li>
