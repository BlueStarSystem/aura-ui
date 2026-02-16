<!DOCTYPE html>
<html lang="it" x-data="{ dark: false }" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura UI — Playground</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('aura::playground.styles')
</head>
<body class="min-h-screen bg-aura-surface-50 dark:bg-aura-surface-900 text-aura-surface-900 dark:text-aura-surface-100 font-aura-sans">
    {{-- Top Bar (right of sidebar) --}}
    <header class="fixed top-0 right-0 left-[260px] h-14 bg-aura-surface-0/80 dark:bg-aura-surface-800/80 backdrop-blur-sm border-b border-aura-surface-200 dark:border-aura-surface-700 flex items-center justify-between px-6 z-10">
        <span class="text-sm font-medium text-aura-surface-500">Component Playground</span>
        <div>
            <button @click="dark = !dark" class="p-2 rounded-aura-md bg-aura-surface-100 dark:bg-aura-surface-700 hover:bg-aura-surface-200 dark:hover:bg-aura-surface-600 aura-transition" :title="dark ? 'Light mode' : 'Dark mode'">
                <template x-if="!dark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/></svg>
                </template>
                <template x-if="dark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                </template>
            </button>
        </div>
    </header>

    <div class="flex min-h-screen">
        {{-- Sidebar Navigation --}}
        <nav class="playground-nav fixed top-0 left-0 bottom-0 w-[260px] bg-aura-surface-0 dark:bg-aura-surface-800 border-r border-aura-surface-200 dark:border-aura-surface-700 overflow-y-auto p-4 flex flex-col gap-1">
            {{-- Brand --}}
            <div class="flex items-center gap-3 px-2 py-4 mb-2">
                <svg class="w-8 h-8 shrink-0" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="14" stroke="url(#aura-grad)" stroke-width="3"/>
                    <circle cx="16" cy="16" r="6" fill="url(#aura-grad)"/>
                    <defs>
                        <linearGradient id="aura-grad" x1="4" y1="4" x2="28" y2="28">
                            <stop stop-color="#6366f1"/><stop offset="1" stop-color="#06b6d4"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div>
                    <h1 class="text-base font-semibold text-aura-surface-900 dark:text-aura-surface-100">Aura UI</h1>
                    <span class="text-xs text-aura-surface-400">{{ View::exists('aura-pro::playground.sections.tabs') ? 'Free + Pro' : 'Free' }} — Playground</span>
                </div>
            </div>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-surface-400 px-2 mt-4 mb-1">Primitives</h2>
            <a href="#buttons" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Button</a>
            <a href="#inputs" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Input</a>
            <a href="#textarea" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Textarea</a>
            <a href="#select" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Select</a>
            <a href="#checkbox-radio" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Checkbox & Radio</a>
            <a href="#toggle" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Toggle</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-surface-400 px-2 mt-4 mb-1">Feedback</h2>
            <a href="#badges" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Badge</a>
            <a href="#alerts" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Alert</a>
            <a href="#spinner" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Spinner & Skeleton</a>
            <a href="#progress" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Progress</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-surface-400 px-2 mt-4 mb-1">Layout</h2>
            <a href="#cards" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Card</a>
            <a href="#modal" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Modal</a>
            <a href="#dropdown" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Dropdown</a>
            <a href="#tooltip" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Tooltip</a>
            <a href="#avatar" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Avatar</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-surface-400 px-2 mt-4 mb-1">Navigation</h2>
            <a href="#breadcrumbs" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Breadcrumbs</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-surface-400 px-2 mt-4 mb-1">Data Display</h2>
            <a href="#empty-state" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Empty State</a>
            <a href="#stats-cards" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Stats Card</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-surface-400 px-2 mt-4 mb-1">Form Layout</h2>
            <a href="#form-layout" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Form & Editor</a>

            {{-- Pro sections (shown only when aura-ui-pro is installed) --}}
            @if(View::exists('aura-pro::playground.sections.tabs'))
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-primary-500 px-2 mt-6 mb-1">Pro — Forms</h2>
            <a href="#date-picker" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Date Picker</a>
            <a href="#time-picker" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Time Picker</a>
            <a href="#autocomplete" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Autocomplete</a>
            <a href="#tags-input" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Tags Input</a>
            <a href="#color-picker" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Color Picker</a>
            <a href="#slider-otp" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Slider & OTP</a>
            <a href="#file-upload" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">File Upload</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-primary-500 px-2 mt-4 mb-1">Pro — Navigation</h2>
            <a href="#tabs" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Tabs</a>
            <a href="#accordion" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Accordion</a>
            <a href="#steps" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Steps</a>
            <a href="#sidebar-nav" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Sidebar</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-primary-500 px-2 mt-4 mb-1">Pro — Interactive</h2>
            <a href="#command-palette" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Command Palette</a>
            <a href="#confirmation-dialog" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Confirmation Dialog</a>
            <a href="#toasts" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Toasts</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-primary-500 px-2 mt-4 mb-1">Pro — Visualization</h2>
            <a href="#charts" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Charts</a>
            <a href="#calendar" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Calendar</a>
            <a href="#kanban" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Kanban</a>
            <a href="#tree-view" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">Tree View</a>
            <h2 class="text-[11px] font-semibold uppercase tracking-widest text-aura-primary-500 px-2 mt-4 mb-1">Pro — DataTable</h2>
            <a href="#datatable-preview" class="block px-3 py-1.5 text-sm text-aura-surface-600 dark:text-aura-surface-400 rounded-aura-md hover:bg-aura-primary-50 dark:hover:bg-aura-surface-700 hover:text-aura-primary-600 aura-transition">DataTable Preview</a>
            @endif
        </nav>

        {{-- Main Content --}}
        <main class="flex-1 ml-[260px] pt-14 p-8">
            {{-- Primitives --}}
            @include('aura::playground.sections.buttons')
            @include('aura::playground.sections.inputs')
            @include('aura::playground.sections.textarea')
            @include('aura::playground.sections.select')
            @include('aura::playground.sections.checkbox-radio')
            @include('aura::playground.sections.toggle')

            {{-- Feedback --}}
            @include('aura::playground.sections.badges')
            @include('aura::playground.sections.alerts')
            @include('aura::playground.sections.spinner')
            @include('aura::playground.sections.progress')

            {{-- Layout --}}
            @include('aura::playground.sections.cards')
            @include('aura::playground.sections.modal')
            @include('aura::playground.sections.dropdown')
            @include('aura::playground.sections.tooltip')
            @include('aura::playground.sections.avatar')

            {{-- Navigation --}}
            @include('aura::playground.sections.breadcrumbs')

            {{-- Data Display --}}
            @include('aura::playground.sections.empty-state')
            @include('aura::playground.sections.stats-cards')

            {{-- Form Layout --}}
            @include('aura::playground.sections.form-layout')

            {{-- Pro sections (shown only when aura-ui-pro is installed) --}}
            @if(View::exists('aura-pro::playground.sections.tabs'))
            <div class="mt-16 mb-8 border-t-2 border-aura-primary-200 dark:border-aura-primary-800 pt-8">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-aura-primary-500 to-aura-secondary-500 bg-clip-text text-transparent mb-2">Pro Components</h2>
                <p class="text-aura-surface-500 text-sm">Advanced components from aura-ui-pro</p>
            </div>

            {{-- Pro Forms --}}
            @include('aura-pro::playground.sections.date-picker')
            @include('aura-pro::playground.sections.time-picker')
            @include('aura-pro::playground.sections.autocomplete')
            @include('aura-pro::playground.sections.tags-input')
            @include('aura-pro::playground.sections.color-picker')
            @include('aura-pro::playground.sections.slider-otp')
            @include('aura-pro::playground.sections.file-upload')

            {{-- Pro Navigation --}}
            @include('aura-pro::playground.sections.tabs')
            @include('aura-pro::playground.sections.accordion')
            @include('aura-pro::playground.sections.steps')
            @include('aura-pro::playground.sections.sidebar-nav')

            {{-- Pro Interactive --}}
            @include('aura-pro::playground.sections.command-palette')
            @include('aura-pro::playground.sections.confirmation-dialog')
            @include('aura-pro::playground.sections.toasts')

            {{-- Pro Visualization --}}
            @include('aura-pro::playground.sections.charts')
            @include('aura-pro::playground.sections.calendar')
            @include('aura-pro::playground.sections.kanban')
            @include('aura-pro::playground.sections.tree-view')

            {{-- Pro DataTable --}}
            @include('aura-pro::playground.sections.datatable-preview')
            @endif
        </main>
    </div>
</body>
</html>
