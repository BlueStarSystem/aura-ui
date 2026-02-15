<!DOCTYPE html>
<html lang="it" x-data="{ dark: false }" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura UI — Playground</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('aura::playground.styles')
</head>
<body class="aura-body" :class="dark ? 'aura-body-dark' : ''">
    {{-- Top Bar (right of sidebar) --}}
    <header class="aura-playground-header">
        <div class="aura-playground-header-inner">
            <span class="aura-playground-header-label">Component Playground</span>
            <div class="aura-playground-actions">
                <button @click="dark = !dark" class="aura-dark-toggle" :title="dark ? 'Light mode' : 'Dark mode'">
                    <template x-if="!dark">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/></svg>
                    </template>
                    <template x-if="dark">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                    </template>
                </button>
            </div>
        </div>
    </header>

    <div class="aura-playground-container">
        {{-- Sidebar Navigation --}}
        <nav class="aura-playground-nav">
            {{-- Brand --}}
            <div class="aura-sidebar-brand">
                <svg class="aura-playground-logo" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="14" stroke="url(#aura-grad)" stroke-width="3"/>
                    <circle cx="16" cy="16" r="6" fill="url(#aura-grad)"/>
                    <defs>
                        <linearGradient id="aura-grad" x1="4" y1="4" x2="28" y2="28">
                            <stop stop-color="#6366f1"/><stop offset="1" stop-color="#06b6d4"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div>
                    <h1 class="aura-playground-title">Aura UI</h1>
                    <span class="aura-playground-version">Playground</span>
                </div>
            </div>
            <h2 class="aura-nav-title">Phase 1 — Base</h2>
            <a href="#buttons" class="aura-nav-link">Button</a>
            <a href="#inputs" class="aura-nav-link">Input</a>
            <a href="#textarea" class="aura-nav-link">Textarea</a>
            <a href="#select" class="aura-nav-link">Select</a>
            <a href="#checkbox-radio" class="aura-nav-link">Checkbox & Radio</a>
            <a href="#toggle" class="aura-nav-link">Toggle</a>
            <a href="#badges" class="aura-nav-link">Badge</a>
            <a href="#alerts" class="aura-nav-link">Alert</a>
            <a href="#cards" class="aura-nav-link">Card</a>
            <a href="#modal" class="aura-nav-link">Modal</a>
            <a href="#dropdown" class="aura-nav-link">Dropdown</a>
            <a href="#tooltip" class="aura-nav-link">Tooltip</a>
            <a href="#avatar" class="aura-nav-link">Avatar</a>
            <a href="#spinner" class="aura-nav-link">Spinner & Skeleton</a>
            <h2 class="aura-nav-title">Phase 2 — Data</h2>
            <a href="#empty-state" class="aura-nav-link">Empty State</a>
            <a href="#stats-cards" class="aura-nav-link">Stats Card</a>
            <a href="#progress" class="aura-nav-link">Progress</a>
            <a href="#datatable-preview" class="aura-nav-link">DataTable</a>
            <h2 class="aura-nav-title">Phase 3 — Forms</h2>
            <a href="#date-picker" class="aura-nav-link">DatePicker</a>
            <a href="#time-picker" class="aura-nav-link">TimePicker</a>
            <a href="#file-upload" class="aura-nav-link">File Upload</a>
            <a href="#autocomplete" class="aura-nav-link">Autocomplete</a>
            <a href="#tags-input" class="aura-nav-link">Tags Input</a>
            <a href="#color-picker" class="aura-nav-link">Color Picker</a>
            <a href="#slider-otp" class="aura-nav-link">Slider & OTP</a>
            <a href="#form-layout" class="aura-nav-link">Form & Editor</a>
            <h2 class="aura-nav-title">Phase 4 — Advanced</h2>
            <a href="#breadcrumbs" class="aura-nav-link">Breadcrumbs</a>
            <a href="#tabs" class="aura-nav-link">Tabs</a>
            <a href="#accordion" class="aura-nav-link">Accordion</a>
            <a href="#steps" class="aura-nav-link">Steps</a>
            <a href="#confirmation-dialog" class="aura-nav-link">Confirmation</a>
            <a href="#toasts" class="aura-nav-link">Toasts</a>
            <a href="#sidebar-nav" class="aura-nav-link">Sidebar Nav</a>
            <a href="#tree-view" class="aura-nav-link">Tree View</a>
            <a href="#command-palette" class="aura-nav-link">Command Palette</a>
            <a href="#charts" class="aura-nav-link">Charts</a>
            <a href="#calendar" class="aura-nav-link">Calendar</a>
            <a href="#kanban" class="aura-nav-link">Kanban Board</a>
        </nav>

        {{-- Main Content --}}
        <main class="aura-playground-main">
            @include('aura::playground.sections.buttons')
            @include('aura::playground.sections.inputs')
            @include('aura::playground.sections.textarea')
            @include('aura::playground.sections.select')
            @include('aura::playground.sections.checkbox-radio')
            @include('aura::playground.sections.toggle')
            @include('aura::playground.sections.badges')
            @include('aura::playground.sections.alerts')
            @include('aura::playground.sections.cards')
            @include('aura::playground.sections.modal')
            @include('aura::playground.sections.dropdown')
            @include('aura::playground.sections.tooltip')
            @include('aura::playground.sections.avatar')
            @include('aura::playground.sections.spinner')

            {{-- Phase 2 — Data Components --}}
            @include('aura::playground.sections.empty-state')
            @include('aura::playground.sections.stats-cards')
            @include('aura::playground.sections.progress')
            @include('aura::playground.sections.datatable-preview')

            {{-- Phase 3 — Form Components --}}
            @include('aura::playground.sections.date-picker')
            @include('aura::playground.sections.time-picker')
            @include('aura::playground.sections.file-upload')
            @include('aura::playground.sections.autocomplete')
            @include('aura::playground.sections.tags-input')
            @include('aura::playground.sections.color-picker')
            @include('aura::playground.sections.slider-otp')
            @include('aura::playground.sections.form-layout')

            {{-- Phase 4 — Advanced Components --}}
            @include('aura::playground.sections.breadcrumbs')
            @include('aura::playground.sections.tabs')
            @include('aura::playground.sections.accordion')
            @include('aura::playground.sections.steps')
            @include('aura::playground.sections.confirmation-dialog')
            @include('aura::playground.sections.toasts')
            @include('aura::playground.sections.sidebar-nav')
            @include('aura::playground.sections.tree-view')
            @include('aura::playground.sections.command-palette')
            @include('aura::playground.sections.charts')
            @include('aura::playground.sections.calendar')
            @include('aura::playground.sections.kanban')
        </main>
    </div>
</body>
</html>
