@props([
    'href' => '#',
    'external' => false,
    'underline' => true,
])

{{--
    An external link opens a new tab, and says so: rel="noopener" closes the
    window.opener hole, and the visually-hidden suffix tells a screen-reader
    user what the icon tells everyone else.
--}}
<a
    href="{{ $href }}"
    @if($external) target="_blank" rel="noopener noreferrer" @endif
    {{ $attributes->class([
        'aura-link text-aura-primary-700 dark:text-aura-primary-400',
        'hover:text-aura-primary-800 dark:hover:text-aura-primary-300',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-aura-primary-600 focus-visible:ring-offset-2 rounded-sm',
        $underline ? 'underline underline-offset-2' : 'no-underline hover:underline',
    ]) }}
>{{ $slot }}@if($external)<x-aura::visually-hidden> ({{ __('aura-ui::messages.opens_in_new_tab') }})</x-aura::visually-hidden>@endif</a>
