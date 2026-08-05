@props([
    'href' => '#',
    'external' => false,
    'underline' => true,
])

@php
    // Blade's {{ }} escapes < > & " ' and stops there, so `javascript:alert(1)`
    // survives it intact and becomes a click away from executing. An
    // application that renders a URL somebody typed — a profile website, a
    // link in a comment — would be handing that through. Unknown schemes
    // become '#': visibly inert rather than silently dangerous.
    $safeHref = \BlueStarSystem\AuraUI\Support\Html::url($href);
@endphp

{{--
    An external link opens a new tab, and says so: rel="noopener" closes the
    window.opener hole, and the visually-hidden suffix tells a screen-reader
    user what the icon tells everyone else.
--}}
<a
    href="{{ $safeHref }}"
    @if($external) target="_blank" rel="noopener noreferrer" @endif
    {{ $attributes->class([
        'aura-link text-aura-primary-700 dark:text-aura-primary-400',
        'hover:text-aura-primary-800 dark:hover:text-aura-primary-300',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-aura-primary-600 focus-visible:ring-offset-2 rounded-sm',
        $underline ? 'underline underline-offset-2' : 'no-underline hover:underline',
    ]) }}
>{{ $slot }}@if($external)<x-aura::visually-hidden> ({{ __('aura-ui::messages.opens_in_new_tab') }})</x-aura::visually-hidden>@endif</a>
