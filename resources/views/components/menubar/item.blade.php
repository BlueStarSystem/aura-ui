@props([
    'href' => null,
    'shortcut' => null,
    'disabled' => false,
])

@php
    use BlueStarSystem\AuraUI\Support\Html;

    /**
     * An item in an open menu. A link when it goes somewhere, a button when it
     * does something — never a div, which takes no focus and answers to no key.
     */
    $tag = $href ? 'a' : 'button';

    $classes = 'aura-menubar-item flex w-full items-center justify-between gap-6 rounded-aura-sm px-3 py-1.5 text-left text-sm text-aura-surface-800 cursor-pointer hover:bg-aura-surface-100 disabled:cursor-not-allowed disabled:opacity-50';
@endphp

<{{ $tag }}
    {{ $attributes->class([$classes]) }}
    role="menuitem"
    @if($href) href="{{ Html::url($href) }}" @else type="button" @endif
    @if($disabled) @if($href) aria-disabled="true" @else disabled @endif @endif
    x-on:click="close(false)"
>
    <span>{{ $slot }}</span>

    @if($shortcut)
        {{-- Decoration for the eye: the shortcut is already announced by the
             application that owns it, and read here it becomes noise. --}}
        <span class="aura-menubar-shortcut text-xs text-aura-surface-500" aria-hidden="true">{{ $shortcut }}</span>
    @endif
</{{ $tag }}>
