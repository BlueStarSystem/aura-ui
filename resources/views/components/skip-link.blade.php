@props([
    'href' => '#main',
])

{{--
    The first thing a keyboard user should reach: a way past the navigation.
    Invisible until focused, then it appears above everything else.

    Put it as the very first element inside <body>, and give the target the
    matching id (x-aura::main takes any attribute, so id="main" works).
--}}
<a
    href="{{ $href }}"
    {{ $attributes->class([
        'aura-skip-link aura-visually-hidden aura-visually-hidden-focusable',
        'focus:z-[100] focus:rounded-md focus:bg-aura-primary-600 focus:px-4 focus:py-2',
        'focus:text-white focus:shadow-aura-lg focus:outline-none focus:ring-2 focus:ring-aura-primary-600 focus:ring-offset-2',
    ]) }}
>{{ \BlueStarSystem\AuraUI\Support\Html::slotIsEmpty($slot) ? __('aura-ui::messages.skip_to_content') : $slot }}</a>
