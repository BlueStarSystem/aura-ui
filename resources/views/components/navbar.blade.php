@props([
    'sticky' => false,
    'glass' => false,
    'bordered' => true,
])

<nav
    {{ $attributes->class([
        'aura-navbar w-full bg-aura-surface-0 z-aura-sticky',
        'sticky top-0' => $sticky,
        'aura-glass backdrop-blur-lg bg-aura-surface-0/80' => $glass,
        'border-b border-aura-surface-200' => $bordered,
    ]) }}
    x-data="{ mobileOpen: false }"
>
    <div class="aura-navbar-inner flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        {{-- Brand slot --}}
        @if(isset($brand))
            <div class="aura-navbar-brand shrink-0">
                {{ $brand }}
            </div>
        @endif

        {{-- Desktop items --}}
        @if(isset($items))
            <div class="aura-navbar-items hidden md:flex items-center gap-1 flex-1 justify-center">
                {{ $items }}
            </div>
        @endif

        {{-- Actions --}}
        @if(isset($actions))
            <div class="aura-navbar-actions hidden md:flex items-center gap-2 shrink-0">
                {{ $actions }}
            </div>
        @endif

        {{-- Mobile hamburger --}}
        <button
            type="button"
            class="aura-navbar-toggle md:hidden inline-flex items-center justify-center w-10 h-10 rounded-aura-md text-aura-surface-500 bg-transparent border-none cursor-pointer aura-transition-fast hover:bg-aura-surface-100 hover:text-aura-surface-900"
            @click="mobileOpen = !mobileOpen"
            x-bind:aria-expanded="mobileOpen"
            aria-label="Toggle navigation"
        >
            <x-aura::icon x-show="!mobileOpen" name="menu" size="md" />
            <x-aura::icon x-show="mobileOpen" name="x" size="md" x-cloak />
        </button>
    </div>

    {{-- Mobile menu --}}
    @if(isset($mobile))
        <div
            class="aura-navbar-mobile md:hidden border-t border-aura-surface-200 bg-aura-surface-0"
            x-show="mobileOpen"
            x-collapse
            x-cloak
        >
            <div class="px-4 py-3 flex flex-col gap-1">
                {{ $mobile }}
            </div>
        </div>
    @endif
</nav>
