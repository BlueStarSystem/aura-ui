@props([
    'for' => null,
    'required' => false,
    'optional' => false,
])

{{--
    The label styling that <x-aura::field> and <x-aura::input> already render,
    available on its own — so an application building a custom control does not
    have to copy the classes out of the package and watch them drift.
--}}
<label
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->class(['aura-label text-[13px] font-semibold text-aura-surface-900 tracking-tight']) }}
>
    {{ $slot }}

    @if($required)
        {{-- The asterisk is decoration; the word is what gets announced. --}}
        <span class="aura-label-required text-aura-danger-600 ml-0.5" aria-hidden="true">*</span>
        <x-aura::visually-hidden>({{ __('aura-ui::messages.required') }})</x-aura::visually-hidden>
    @elseif($optional)
        <span class="aura-label-optional ml-1 text-xs font-normal text-aura-surface-600">({{ __('aura-ui::messages.optional') }})</span>
    @endif
</label>
