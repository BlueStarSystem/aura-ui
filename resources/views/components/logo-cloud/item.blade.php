@props([
    'name' => null,
    'src' => null,
    'href' => null,
    'height' => '2rem',
])

@php
    /**
     * The logo is the company's name in picture form, so `name` becomes the
     * alt text. A logo with an empty alt is a company nobody using a screen
     * reader can tell you about — and "who else uses this" is the entire point
     * of the section.
     */
    $inner = $src
        ? '<img src="'.e(\BlueStarSystem\AuraUI\Support\Html::url($src)).'" alt="'.e($name ?? '').'" class="aura-logo-cloud-image max-h-full w-auto object-contain" style="height: '.e(\BlueStarSystem\AuraUI\Support\Html::cssValue($height) ?? '2rem').'" />'
        : null;
@endphp

<li class="aura-logo-cloud-item flex items-center justify-center">
    @if($href)
        <a href="{{ \BlueStarSystem\AuraUI\Support\Html::url($href) }}" class="aura-logo-cloud-link inline-flex items-center justify-center aura-transition-fast hover:opacity-100">
            @if($inner){!! $inner !!}@else{{ $slot }}@endif
        </a>
    @else
        @if($inner){!! $inner !!}@else{{ $slot }}@endif
    @endif
</li>
