@props([
    'options' => [],
    'value' => null,
    'name' => null,
    'label' => null,
    'size' => 'md',
    'fullWidth' => false,
])

@php
    /**
     * A radiogroup, not a row of buttons. Radio semantics are what give the
     * arrow keys their meaning and let a screen reader say "2 of 3" — a set of
     * buttons announces three unrelated controls and leaves the reader to guess
     * that only one can be chosen.
     */
    $items = [];

    foreach ($options as $key => $option) {
        $items[] = is_array($option)
            ? ['value' => $option['value'] ?? $key, 'label' => $option['label'] ?? $option['value'] ?? $key, 'icon' => $option['icon'] ?? null, 'disabled' => (bool) ($option['disabled'] ?? false)]
            : ['value' => is_int($key) ? $option : $key, 'label' => $option, 'icon' => null, 'disabled' => false];
    }

    $selected = $value ?? ($items[0]['value'] ?? null);
    $groupId = 'aura-segmented-'.\Illuminate\Support\Str::random(8);
    $inputName = $name ?? $groupId;

    $sizeClass = match ($size) {
        'sm' => 'text-xs px-2.5 py-1',
        'lg' => 'text-base px-4 py-2',
        default => 'text-sm px-3 py-1.5',
    };
@endphp

<div
    {{ $attributes->class(['aura-segmented-control inline-flex rounded-aura-md bg-aura-surface-100 p-0.5', $fullWidth ? 'flex w-full' : '']) }}
    role="radiogroup"
    @if($label) aria-labelledby="{{ $groupId }}-label" @endif
    x-data="{ selected: {{ Js::from($selected) }} }"
>
    @if($label)
        <span id="{{ $groupId }}-label" class="aura-visually-hidden">{{ $label }}</span>
    @endif

    @foreach($items as $i => $item)
        @php $optionId = $groupId.'-'.$i; @endphp

        <label
            for="{{ $optionId }}"
            class="aura-segmented-option relative inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-aura-sm font-medium aura-transition-fast {{ $sizeClass }} {{ $fullWidth ? 'flex-1' : '' }} {{ $item['disabled'] ? 'cursor-not-allowed opacity-50' : '' }}"
            x-bind:class="selected === {{ Js::from($item['value']) }}
                ? 'aura-segmented-selected bg-aura-surface-0 text-aura-surface-900 shadow-aura-sm'
                : 'text-aura-surface-600 hover:text-aura-surface-900'"
        >
            {{-- A real radio, visually hidden but focusable: the browser gives
                 arrow-key navigation, the roving tab stop and the "2 of 3"
                 announcement for nothing. --}}
            <input
                type="radio"
                id="{{ $optionId }}"
                name="{{ $inputName }}"
                value="{{ $item['value'] }}"
                class="aura-segmented-input absolute inset-0 h-full w-full cursor-pointer opacity-0"
                x-model="selected"
                @if($item['disabled']) disabled @endif
                {{ $attributes->only(['wire:model', 'wire:model.live', 'x-model']) }}
            />

            @if($item['icon'])
                <x-aura::icon :name="$item['icon']" size="xs" aria-hidden="true" />
            @endif

            <span>{{ $item['label'] }}</span>
        </label>
    @endforeach
</div>
