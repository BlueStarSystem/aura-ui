@props([
    'name' => '',
    'role' => null,
    'bio' => null,
    'avatar' => null,
    'initials' => null,
    'align' => 'center',
])

@php
    $memberId = 'aura-team-member-'.\Illuminate\Support\Str::random(8);
    $alignClass = $align === 'left' ? 'items-start text-left' : 'items-center text-center';
@endphp

<li class="aura-team-member flex flex-col {{ $alignClass }}">
    @if($avatar)
        {{-- The photo carries the person's name as its alt. A decorative
             empty alt would leave a screen-reader user with a role and a bio
             belonging to nobody. --}}
        <img
            src="{{ \BlueStarSystem\AuraUI\Support\Html::url($avatar) }}"
            alt="{{ $name }}"
            class="aura-team-avatar h-24 w-24 rounded-full object-cover"
        />
    @else
        <x-aura::avatar :name="$name" :initials="$initials" size="xl" />
    @endif

    <p id="{{ $memberId }}-name" class="aura-team-member-name mt-4 font-semibold text-aura-surface-900">{{ $name }}</p>

    @if($role)
        <p class="aura-team-member-role text-sm text-aura-primary-700 dark:text-aura-primary-400">{{ $role }}</p>
    @endif

    @if($bio)
        <p class="aura-team-member-bio mt-2 text-sm text-aura-surface-600">{{ $bio }}</p>
    @endif

    @if(isset($links))
        {{-- Named after the person: a page of ten members otherwise gives a
             screen-reader user ten identical "Social links" groups with no way
             to tell whose is whose. --}}
        <nav class="aura-team-member-links mt-3 flex gap-2" aria-labelledby="{{ $memberId }}-name">
            {{ $links }}
        </nav>
    @endif
</li>
