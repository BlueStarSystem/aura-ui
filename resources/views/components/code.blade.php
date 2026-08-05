@props([])

{{-- Inline code inside running text. For a whole snippet use <x-aura::code-block>. --}}
<code {{ $attributes->class([
    'aura-code rounded border border-aura-surface-200 bg-aura-surface-100',
    'px-1.5 py-0.5 font-mono text-[0.875em] text-aura-surface-900',
]) }}>{{ $slot }}</code>
