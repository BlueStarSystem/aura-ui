@props([
    'label' => null,
    'storageKey' => 'aura-theme',
    'variant' => 'segmented',
])

@php
    /**
     * Light, dark, or whatever the operating system says.
     *
     * "System" is a real third state, not the absence of a choice: someone who
     * has never touched the control should follow their OS, and someone who
     * picked light should stay on light when the OS flips at sunset. Two
     * buttons cannot express that.
     */
    $groupId = 'aura-theme-'.\Illuminate\Support\Str::random(8);
    $groupLabel = $label ?? __('aura-ui::messages.theme');

    $options = [
        ['value' => 'light', 'icon' => 'sun', 'label' => __('aura-ui::messages.theme_light')],
        ['value' => 'dark', 'icon' => 'moon', 'label' => __('aura-ui::messages.theme_dark')],
        ['value' => 'system', 'icon' => 'monitor', 'label' => __('aura-ui::messages.theme_system')],
    ];
@endphp

<div
    {{ $attributes->class(['aura-theme-controller inline-flex rounded-aura-md bg-aura-surface-100 p-0.5']) }}
    role="radiogroup"
    aria-labelledby="{{ $groupId }}-label"
    x-data="{
        theme: 'system',
        key: {{ Js::from($storageKey) }},

        init() {
            this.theme = localStorage.getItem(this.key) || 'system';
            this.apply();

            // Following the system means following it as it changes, not only
            // reading it once at load.
            window.matchMedia('(prefers-color-scheme: dark)')
                .addEventListener('change', () => { if (this.theme === 'system') this.apply(); });

            this.$watch('theme', () => {
                localStorage.setItem(this.key, this.theme);
                this.apply();
            });
        },

        apply() {
            const dark = this.theme === 'dark'
                || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

            document.documentElement.classList.toggle('dark', dark);
            window.dispatchEvent(new CustomEvent('aura-theme-changed', { detail: { theme: this.theme, dark } }));
        }
    }"
>
    <span id="{{ $groupId }}-label" class="aura-visually-hidden">{{ $groupLabel }}</span>

    @foreach($options as $i => $option)
        @php $optionId = $groupId.'-'.$i; @endphp

        <label
            for="{{ $optionId }}"
            class="aura-theme-option relative inline-flex cursor-pointer items-center justify-center rounded-aura-sm px-2.5 py-1.5 aura-transition-fast"
            x-bind:class="theme === {{ Js::from($option['value']) }}
                ? 'aura-theme-selected bg-aura-surface-0 text-aura-surface-900 shadow-aura-sm'
                : 'text-aura-surface-600 hover:text-aura-surface-900'"
        >
            {{-- A real radio: the browser supplies arrow-key navigation, one tab
                 stop for the group and the "2 of 3" announcement. --}}
            <input
                type="radio"
                id="{{ $optionId }}"
                name="{{ $groupId }}"
                value="{{ $option['value'] }}"
                class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                x-model="theme"
            />

            <x-aura::icon :name="$option['icon']" size="sm" aria-hidden="true" />
            <span class="aura-visually-hidden">{{ $option['label'] }}</span>
        </label>
    @endforeach
</div>
