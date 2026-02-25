@props([
    'name' => null,
    'title' => null,
    'position' => 'right',
    'size' => 'md',
    'overlay' => true,
    'closeable' => true,
])

@php
    $sizeMap = match($size) {
        'sm' => '320px',
        'lg' => '576px',
        'xl' => '672px',
        'full' => '100%',
        default => '448px',
    };

    $isHorizontal = in_array($position, ['top', 'bottom']);

    $translateHidden = match($position) {
        'left' => 'translateX(-100%)',
        'top' => 'translateY(-100%)',
        'bottom' => 'translateY(100%)',
        default => 'translateX(100%)',
    };

    $positionStyle = match($position) {
        'left' => 'left:0;top:0;bottom:0;',
        'top' => 'top:0;left:0;right:0;',
        'bottom' => 'bottom:0;left:0;right:0;',
        default => 'right:0;top:0;bottom:0;',
    };

    $panelSize = $isHorizontal ? "width:100%;max-height:{$sizeMap};" : "height:100%;max-width:{$sizeMap};";
@endphp

<div x-data="{
        drawerOpen: false,
        openDrawer() { this.drawerOpen = true; },
        closeDrawer() { this.drawerOpen = false; }
     }"
     @if($name)
     x-on:open-drawer.window="if ($event.detail === '{{ $name }}') openDrawer()"
     x-on:close-drawer.window="if ($event.detail === '{{ $name }}') closeDrawer()"
     @endif
     x-on:keydown.escape.window="closeDrawer()"
     {{ $attributes }}>

    {{-- Trigger slot --}}
    @if(isset($trigger))
        <div x-on:click="openDrawer()">
            {{ $trigger }}
        </div>
    @endif

    {{-- Overlay --}}
    @if($overlay)
    <div x-show="drawerOpen"
         x-cloak
         style="position:fixed;inset:0;z-index:70;background:rgba(0,0,0,0.5);"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @if($closeable) x-on:click="closeDrawer()" @endif>
    </div>
    @endif

    {{-- Panel: uses visibility+transform instead of x-show for smooth slide animation --}}
    <div x-cloak
         x-on:click.stop
         style="position:fixed;z-index:71;{{ $positionStyle }}{{ $panelSize }}background:var(--aura-surface-0, #fff);box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);transition:transform 0.3s ease,visibility 0.3s;overflow:hidden;"
         :style="{ transform: drawerOpen ? 'translate(0,0)' : '{{ $translateHidden }}', visibility: drawerOpen ? 'visible' : 'hidden' }">

        @if($title || $closeable)
        <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--aura-surface-200, #e5e7eb);padding:1rem 1.5rem;">
            @if($title)
                <h3 style="font-size:1.125rem;font-weight:600;color:var(--aura-surface-900, #111827);margin:0;">{{ $title }}</h3>
            @else
                <div></div>
            @endif
            @if($closeable)
                <button x-on:click="closeDrawer()" type="button" style="padding:0.25rem;color:var(--aura-surface-400, #9ca3af);cursor:pointer;border:none;background:none;line-height:0;" aria-label="Close">
                    <svg style="width:1.25rem;height:1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            @endif
        </div>
        @endif

        <div style="overflow-y:auto;padding:1.5rem;{{ $isHorizontal ? 'max-height:80vh' : 'height:calc(100% - 65px)' }}">
            {{ $slot }}
        </div>

        @if(isset($footer))
            <div style="border-top:1px solid var(--aura-surface-200, #e5e7eb);padding:1rem 1.5rem;display:flex;align-items:center;justify-content:flex-end;gap:0.5rem;">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
