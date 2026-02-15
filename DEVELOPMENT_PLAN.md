# Aura UI — Piano di Sviluppo Completo

**Package**: `bluestarsystem/aura-ui`
**Namespace**: `BlueStarSystem\AuraUI`
**Path**: `C:\laragon\www\packages\bluestarsystem\aura-ui`
**Autore**: Juri Montico — BlueStarSystem
**Licenza**: MIT (o proprietaria, da decidere)
**Creazione**: 2026-02-15

---

## 1. Vision & Obiettivi

### Cosa e'
Libreria UI component per Laravel 12 + Livewire 4 + Alpine.js + Tailwind CSS 4.
Design language **"Vibrant Depth"** — profondita' stratificata, gradient vivi, micro-animazioni, glass morphism selettivo.

### Cosa NON e'
- NON e' un admin panel (non e' Filament)
- NON e' un page builder
- NON e' un framework CSS (e' costruito SU Tailwind 4)

### Obiettivi
1. Componenti Blade/Livewire riutilizzabili con API dichiarativa
2. Design vivace e professionale (dark mode nativo)
3. DataTable avanzata con search/filter/sort/pagination/inline-edit/bulk-actions
4. Form builder leggero e dichiarativo
5. Accessibilita' WCAG 2.1 AA
6. Zero JavaScript esterno — solo Alpine.js
7. Testabile al 100% con Pest + Livewire Testing
8. Documentazione inline (ogni componente auto-documentato)

### Target progetti
- BeautyFlow Pro (SaaS saloni)
- Kelvio v3 (SaaS ristorazione)
- MenuStudio2 (menu digitali)
- Futuri progetti Laravel/Livewire BSS

---

## 2. Architettura Package

### Struttura directory

```
aura-ui/
├── CLAUDE.md                          # Istruzioni per Claude Code
├── DEVELOPMENT_PLAN.md                # Questo documento
├── composer.json
├── package.json                       # Alpine plugins + build tools
├── vite.config.js                     # Build CSS/JS
├── tailwind.plugin.js                 # Tailwind 4 plugin custom
├── config/
│   └── aura-ui.php                    # Config pubblicabile
├── resources/
│   ├── css/
│   │   ├── aura.css                   # Entry point CSS
│   │   ├── base/
│   │   │   ├── variables.css          # CSS custom properties (colori, ombre, animazioni)
│   │   │   ├── reset.css              # Normalizzazioni base
│   │   │   └── typography.css         # Scale tipografiche
│   │   ├── components/
│   │   │   ├── button.css
│   │   │   ├── input.css
│   │   │   ├── modal.css
│   │   │   └── ...                    # Un file per componente
│   │   └── utilities/
│   │       ├── animations.css         # Keyframes e transizioni
│   │       ├── shadows.css            # Shadow system multi-livello
│   │       └── glass.css              # Glass morphism utilities
│   ├── js/
│   │   ├── aura.js                    # Entry point JS
│   │   └── plugins/
│   │       ├── tooltip.js             # Alpine plugin tooltip
│   │       ├── dropdown.js            # Alpine plugin dropdown
│   │       ├── modal.js               # Alpine plugin modal
│   │       └── ...
│   └── views/
│       └── components/
│           ├── button.blade.php
│           ├── input.blade.php
│           ├── modal.blade.php
│           └── ...
├── src/
│   ├── AuraUIServiceProvider.php      # Service provider principale
│   ├── AuraUI.php                     # Facade
│   ├── Components/                    # Classi componenti Blade (se servono logica)
│   │   ├── Button.php
│   │   ├── Input.php
│   │   └── ...
│   ├── Traits/                        # Trait riutilizzabili per Livewire
│   │   ├── WithAuraDataTable.php      # Evoluzione di WithDataTable
│   │   ├── WithAuraModal.php          # Gestione modal state
│   │   ├── WithAuraFilters.php        # Filtri avanzati
│   │   ├── WithAuraBulkActions.php    # Selezione multipla + azioni
│   │   └── WithAuraInlineEdit.php     # Editing inline celle
│   ├── Support/
│   │   ├── Color.php                  # Helper colori (hex, rgb, hsl)
│   │   ├── ComponentAttributeBag.php  # Merge attributi avanzato
│   │   └── Theme.php                  # Gestione tema runtime
│   └── Commands/
│       ├── InstallCommand.php         # php artisan aura:install
│       └── ThemeCommand.php           # php artisan aura:theme
├── stubs/
│   └── aura-theme.css                 # Stub tema personalizzato
├── tests/
│   ├── Pest.php
│   ├── TestCase.php
│   ├── Unit/
│   │   ├── Components/
│   │   │   ├── ButtonTest.php
│   │   │   └── ...
│   │   └── Traits/
│   │       └── WithAuraDataTableTest.php
│   └── Browser/                       # Test Livewire (rendering + interazioni)
│       ├── ButtonTest.php
│       └── ...
└── docs/                              # Documentazione componenti
    └── components/
        ├── button.md
        └── ...
```

### Dipendenze

```json
{
    "require": {
        "php": "^8.3",
        "illuminate/support": "^12.0",
        "illuminate/view": "^12.0",
        "livewire/livewire": "^3.6"
    },
    "require-dev": {
        "orchestra/testbench": "^10.0",
        "pestphp/pest": "^3.0",
        "pestphp/pest-plugin-livewire": "^3.0"
    }
}
```

### Prefisso componenti

Tutti i componenti usano il prefisso `<x-aura::*>`:

```blade
<x-aura::button>Click me</x-aura::button>
<x-aura::input label="Email" type="email" wire:model="email" />
<x-aura::modal name="confirm-delete">...</x-aura::modal>
```

### Installazione

```bash
composer require bluestarsystem/aura-ui
php artisan aura:install     # Pubblica config + CSS stub
npm install                  # Installa dipendenze JS (Alpine plugins)
```

---

## 3. Design System — "Vibrant Depth"

### 3.1 Palette Colori (CSS Custom Properties)

```css
:root {
    /* === PRIMARY (Deep Blue → Indigo) === */
    --aura-primary-50:  #eef2ff;
    --aura-primary-100: #e0e7ff;
    --aura-primary-200: #c7d2fe;
    --aura-primary-300: #a5b4fc;
    --aura-primary-400: #818cf8;
    --aura-primary-500: #6366f1;   /* Base */
    --aura-primary-600: #4f46e5;
    --aura-primary-700: #4338ca;
    --aura-primary-800: #3730a3;
    --aura-primary-900: #312e81;
    --aura-primary-950: #1e1b4b;

    /* === SECONDARY (Teal/Cyan) === */
    --aura-secondary-50:  #ecfeff;
    --aura-secondary-500: #06b6d4;  /* Base */
    --aura-secondary-700: #0e7490;

    /* === SUCCESS (Emerald vivo) === */
    --aura-success-50:  #ecfdf5;
    --aura-success-500: #10b981;   /* Base */
    --aura-success-700: #047857;

    /* === WARNING (Amber caldo) === */
    --aura-warning-50:  #fffbeb;
    --aura-warning-500: #f59e0b;   /* Base */
    --aura-warning-700: #b45309;

    /* === DANGER (Coral/Rosso) === */
    --aura-danger-50:  #fef2f2;
    --aura-danger-500: #ef4444;    /* Base */
    --aura-danger-700: #b91c1c;

    /* === INFO (Sky luminoso) === */
    --aura-info-50:  #f0f9ff;
    --aura-info-500: #0ea5e9;     /* Base */
    --aura-info-700: #0369a1;

    /* === SURFACES === */
    --aura-surface-0:   #ffffff;           /* Background principale */
    --aura-surface-50:  #f8fafc;           /* Card background */
    --aura-surface-100: #f1f5f9;           /* Input background */
    --aura-surface-200: #e2e8f0;           /* Border, divider */
    --aura-surface-300: #cbd5e1;           /* Border hover */
    --aura-surface-700: #334155;           /* Testo secondario */
    --aura-surface-800: #1e293b;           /* Testo primario */
    --aura-surface-900: #0f172a;           /* Heading */

    /* === GRADIENTS === */
    --aura-gradient-primary: linear-gradient(135deg, #6366f1, #4f46e5);
    --aura-gradient-secondary: linear-gradient(135deg, #06b6d4, #0ea5e9);
    --aura-gradient-success: linear-gradient(135deg, #10b981, #059669);
    --aura-gradient-danger: linear-gradient(135deg, #ef4444, #dc2626);
    --aura-gradient-surface: linear-gradient(135deg, #f8fafc, #f1f5f9);
}
```

### 3.2 Dark Mode

```css
.dark, [data-theme="dark"] {
    --aura-surface-0:   #0f172a;          /* Blu scuro profondo, MAI nero puro */
    --aura-surface-50:  #1e293b;
    --aura-surface-100: #334155;
    --aura-surface-200: #475569;
    --aura-surface-300: #64748b;
    --aura-surface-700: #cbd5e1;
    --aura-surface-800: #e2e8f0;
    --aura-surface-900: #f8fafc;

    /* In dark mode i colori accent BRILLANO */
    --aura-primary-500: #818cf8;          /* Piu' chiaro e vivace */
    --aura-success-500: #34d399;
    --aura-warning-500: #fbbf24;
    --aura-danger-500:  #fb7185;

    /* Glow amplificato in dark mode */
    --aura-glow-intensity: 0.25;          /* vs 0.15 in light */
}
```

### 3.3 Shadow System

```css
:root {
    /* Shadows multi-livello per profondita' realistica */
    --aura-shadow-xs:  0 1px 2px rgba(0,0,0,0.05);
    --aura-shadow-sm:  0 1px 2px rgba(0,0,0,0.06),
                       0 1px 3px rgba(0,0,0,0.1);
    --aura-shadow-md:  0 4px 6px rgba(0,0,0,0.05),
                       0 2px 4px rgba(0,0,0,0.06),
                       0 0 0 1px rgba(0,0,0,0.03);
    --aura-shadow-lg:  0 10px 15px rgba(0,0,0,0.1),
                       0 4px 6px rgba(0,0,0,0.05),
                       0 0 0 1px rgba(0,0,0,0.02);
    --aura-shadow-xl:  0 20px 25px rgba(0,0,0,0.1),
                       0 8px 10px rgba(0,0,0,0.04);

    /* Glow colorati per focus/active */
    --aura-glow-primary: 0 0 0 3px rgba(99,102,241, var(--aura-glow-intensity, 0.15));
    --aura-glow-success: 0 0 0 3px rgba(16,185,129, var(--aura-glow-intensity, 0.15));
    --aura-glow-danger:  0 0 0 3px rgba(239,68,68, var(--aura-glow-intensity, 0.15));
    --aura-glow-warning: 0 0 0 3px rgba(245,158,11, var(--aura-glow-intensity, 0.15));
}
```

### 3.4 Animazioni & Transizioni

```css
:root {
    /* Timing functions */
    --aura-ease-out:     cubic-bezier(0.16, 1, 0.3, 1);
    --aura-ease-in-out:  cubic-bezier(0.45, 0, 0.55, 1);
    --aura-ease-spring:  cubic-bezier(0.34, 1.56, 0.64, 1);  /* Bounce leggero */

    /* Durate */
    --aura-duration-fast:   100ms;
    --aura-duration-normal: 150ms;
    --aura-duration-slow:   250ms;
    --aura-duration-enter:  200ms;
    --aura-duration-leave:  150ms;
}

/* Keyframes condivisi */
@keyframes aura-fade-in     { from { opacity: 0; } to { opacity: 1; } }
@keyframes aura-fade-out    { from { opacity: 1; } to { opacity: 0; } }
@keyframes aura-slide-up    { from { transform: translateY(8px); opacity: 0; } }
@keyframes aura-slide-down  { from { transform: translateY(-8px); opacity: 0; } }
@keyframes aura-scale-in    { from { transform: scale(0.95); opacity: 0; } }
@keyframes aura-shimmer     { from { background-position: -200% 0; } to { background-position: 200% 0; } }
@keyframes aura-spin        { to { transform: rotate(360deg); } }
@keyframes aura-pulse-glow  { 0%, 100% { box-shadow: var(--aura-glow-primary); }
                              50% { box-shadow: 0 0 0 6px rgba(99,102,241, 0.08); } }
```

### 3.5 Tipografia

```css
:root {
    --aura-font-sans:  'Inter', ui-sans-serif, system-ui, sans-serif;
    --aura-font-mono:  'JetBrains Mono', ui-monospace, monospace;

    /* Scale tipografica */
    --aura-text-xs:   0.75rem;    /* 12px */
    --aura-text-sm:   0.875rem;   /* 14px */
    --aura-text-base: 1rem;       /* 16px */
    --aura-text-lg:   1.125rem;   /* 18px */
    --aura-text-xl:   1.25rem;    /* 20px */
    --aura-text-2xl:  1.5rem;     /* 24px */
    --aura-text-3xl:  1.875rem;   /* 30px */

    /* Pesi con contrasto forte */
    --aura-font-light:    300;
    --aura-font-normal:   400;
    --aura-font-medium:   500;
    --aura-font-semibold: 600;
    --aura-font-bold:     700;
}
```

### 3.6 Spacing & Border Radius

```css
:root {
    /* Border radius — geometria morbida */
    --aura-radius-sm:   6px;    /* Badge, chip */
    --aura-radius-md:   8px;    /* Input, button */
    --aura-radius-lg:   12px;   /* Card, alert */
    --aura-radius-xl:   16px;   /* Modal, sheet */
    --aura-radius-full: 9999px; /* Avatar, toggle */
}
```

### 3.7 Glass Morphism

```css
.aura-glass {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(12px) saturate(1.5);
    -webkit-backdrop-filter: blur(12px) saturate(1.5);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dark .aura-glass {
    background: rgba(15, 23, 42, 0.75);
    border: 1px solid rgba(255, 255, 255, 0.08);
}
```

### 3.8 Interazioni Standard

Ogni elemento interattivo segue questo pattern:

| Stato    | Effetto                                              |
|----------|------------------------------------------------------|
| Default  | Shadow sm, colore base, scale(1)                     |
| Hover    | Shadow md, brightness +5%, scale(1.02)               |
| Focus    | Glow colorato (ring con luminosita'), outline:none    |
| Active   | Shadow xs, brightness -5%, scale(0.98)               |
| Disabled | Opacity 0.5, cursor not-allowed, no transitions      |
| Loading  | Shimmer gradient animato / spinner                    |

---

## 4. Fasi di Sviluppo

---

### FASE 0 — Fondamenta (Package Bootstrap)
**Obiettivo**: Package funzionante con design system, installabile via Composer.

| # | Task | Dettaglio |
|---|------|-----------|
| 0.1 | composer.json | Autoload PSR-4, dipendenze, metadata |
| 0.2 | ServiceProvider | Registrazione views, config, comandi |
| 0.3 | Config file | `config/aura-ui.php` (prefix, theme, dark mode) |
| 0.4 | CSS Design System | Tutte le variabili CSS (colori, ombre, animazioni, tipografia) |
| 0.5 | Tailwind Plugin | Plugin per Tailwind 4 che registra le utility Aura |
| 0.6 | Install Command | `php artisan aura:install` — pubblica config e CSS |
| 0.7 | Test setup | Pest + TestCase con Orchestra Testbench |
| 0.8 | CI base | phpunit.xml, test workflow |

**Output**: `composer require bluestarsystem/aura-ui` funziona, CSS importabile.

---

### FASE 1 — Componenti Primitivi
**Obiettivo**: Tutti i building block base. Ogni componente ha test, dark mode, e tutti gli stati interattivi.

#### 1.1 Button
```blade
<x-aura::button>Default</x-aura::button>
<x-aura::button variant="primary" size="lg" icon="plus">Add Item</x-aura::button>
<x-aura::button variant="danger" outline loading>Deleting...</x-aura::button>
<x-aura::button variant="ghost" icon-only><x-aura::icon name="trash" /></x-aura::button>
```

| Prop | Tipo | Default | Valori |
|------|------|---------|--------|
| variant | string | 'primary' | primary, secondary, success, warning, danger, ghost, link |
| size | string | 'md' | xs, sm, md, lg, xl |
| outline | bool | false | — |
| gradient | bool | false | Usa gradient invece di colore piatto |
| loading | bool | false | Mostra spinner e disabilita |
| disabled | bool | false | — |
| icon | string | null | Nome icona (start) |
| icon-right | string | null | Nome icona (end) |
| icon-only | bool | false | Bottone quadrato con sola icona |
| href | string | null | Renderizza come `<a>` |
| type | string | 'button' | button, submit, reset |

**Animazioni**: hover scale(1.02) + shadow elevazione, active scale(0.98), loading spin.

#### 1.2 Input
```blade
<x-aura::input
    label="Email"
    type="email"
    placeholder="nome@esempio.it"
    wire:model="email"
    hint="Inserisci la tua email aziendale"
    error="{{ $errors->first('email') }}"
    prefix-icon="envelope"
/>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| label | string | null | Label sopra l'input |
| type | string | 'text' | Tutti i tipi HTML5 |
| placeholder | string | null | — |
| hint | string | null | Testo aiuto sotto l'input |
| error | string | null | Messaggio errore (stato rosso) |
| prefix | string/slot | null | Testo/icona prima |
| suffix | string/slot | null | Testo/icona dopo |
| prefix-icon | string | null | Icona nel prefix |
| suffix-icon | string | null | Icona nel suffix |
| clearable | bool | false | Mostra X per svuotare |
| disabled | bool | false | — |
| readonly | bool | false | — |
| size | string | 'md' | sm, md, lg |

**Animazioni**: focus → border primary + glow, errore → shake leggero + border danger + glow rosso.

#### 1.3 Textarea
```blade
<x-aura::textarea
    label="Descrizione"
    wire:model="description"
    rows="4"
    auto-resize
    character-count
    maxlength="500"
/>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| label | string | null | — |
| rows | int | 3 | Altezza iniziale |
| auto-resize | bool | false | Cresce con il contenuto |
| character-count | bool | false | Mostra contatore caratteri |
| maxlength | int | null | Limite caratteri |
| hint | string | null | — |
| error | string | null | — |
| size | string | 'md' | sm, md, lg |

#### 1.4 Select
```blade
<x-aura::select label="Paese" wire:model="country" placeholder="Seleziona...">
    <x-aura::select.option value="IT">Italia</x-aura::select.option>
    <x-aura::select.option value="DE">Germania</x-aura::select.option>
</x-aura::select>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| label | string | null | — |
| placeholder | string | null | Opzione vuota |
| error | string | null | — |
| hint | string | null | — |
| disabled | bool | false | — |
| size | string | 'md' | sm, md, lg |

#### 1.5 Checkbox & Radio
```blade
<x-aura::checkbox wire:model="terms" label="Accetto i termini" />
<x-aura::checkbox wire:model="features" value="sms" label="SMS" description="Notifiche via SMS" />

<x-aura::radio-group wire:model="plan" label="Piano">
    <x-aura::radio value="free" label="Free" description="Per iniziare" />
    <x-aura::radio value="pro" label="Pro" description="Per professionisti" />
</x-aura::radio-group>
```

**Animazioni**: check → scale bounce con spring easing. Radio → dot scale-in.

#### 1.6 Toggle / Switch
```blade
<x-aura::toggle wire:model="notifications" label="Notifiche email" />
<x-aura::toggle wire:model="darkMode" label="Dark mode" size="lg" on-icon="sun" off-icon="moon" />
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| label | string | null | — |
| description | string | null | Sotto-testo |
| size | string | 'md' | sm, md, lg |
| color | string | 'primary' | Colore quando ON |
| on-icon | string | null | Icona stato ON |
| off-icon | string | null | Icona stato OFF |
| disabled | bool | false | — |

**Animazioni**: knob slide con spring easing, cambio colore background sfumato.

#### 1.7 Badge
```blade
<x-aura::badge>Default</x-aura::badge>
<x-aura::badge variant="success" dot>Attivo</x-aura::badge>
<x-aura::badge variant="danger" icon="exclamation" removable wire:click="remove">Errore</x-aura::badge>
<x-aura::badge size="lg" gradient>Premium</x-aura::badge>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| variant | string | 'default' | primary, secondary, success, warning, danger, info |
| size | string | 'md' | sm, md, lg |
| dot | bool | false | Pallino indicatore |
| icon | string | null | — |
| removable | bool | false | Mostra X |
| outline | bool | false | Solo bordo |
| gradient | bool | false | Sfondo gradient |
| rounded | bool | false | Pill shape |

#### 1.8 Alert
```blade
<x-aura::alert variant="success" icon="check-circle" dismissible>
    <x-slot:title>Operazione completata</x-slot:title>
    Il record e' stato salvato con successo.
    <x-slot:actions>
        <x-aura::button size="sm" variant="success" outline>Visualizza</x-aura::button>
    </x-slot:actions>
</x-aura::alert>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| variant | string | 'info' | info, success, warning, danger |
| icon | string | auto | Icona automatica per variant |
| dismissible | bool | false | Mostra X per chiudere |
| bordered | bool | false | Bordo laterale colorato |

**Animazioni**: enter slide-down + fade-in, dismiss fade-out + collapse altezza.

#### 1.9 Card
```blade
<x-aura::card>
    <x-slot:header>
        <x-aura::card.title>Titolo</x-aura::card.title>
        <x-aura::card.description>Descrizione</x-aura::card.description>
    </x-slot:header>

    Contenuto della card...

    <x-slot:footer class="justify-end">
        <x-aura::button variant="ghost">Annulla</x-aura::button>
        <x-aura::button>Salva</x-aura::button>
    </x-slot:footer>
</x-aura::card>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| padding | string | 'md' | none, sm, md, lg |
| shadow | string | 'md' | none, sm, md, lg |
| hover | bool | false | Elevazione su hover |
| bordered | bool | true | Bordo sottile |
| glass | bool | false | Effetto glass morphism |

#### 1.10 Modal
```blade
<x-aura::modal name="confirm-delete" max-width="md" glass>
    <x-slot:title>Conferma eliminazione</x-slot:title>

    Sei sicuro di voler eliminare questo record?

    <x-slot:footer>
        <x-aura::button variant="ghost" x-on:click="$dispatch('close-modal', 'confirm-delete')">
            Annulla
        </x-aura::button>
        <x-aura::button variant="danger" wire:click="delete">Elimina</x-aura::button>
    </x-slot:footer>
</x-aura::modal>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| name | string | required | Identificativo unico |
| max-width | string | 'lg' | sm, md, lg, xl, 2xl, full |
| glass | bool | false | Effetto glass morphism |
| closeable | bool | true | Chiudibile con click fuori/ESC |
| slide-over | bool | false | Panel laterale invece di centered |
| position | string | 'right' | left, right (solo con slide-over) |

**Animazioni**: backdrop fade-in, modal scale-in (centered) o slide-in (slide-over). Chiusura inversa.

#### 1.11 Dropdown
```blade
<x-aura::dropdown>
    <x-slot:trigger>
        <x-aura::button>Opzioni</x-aura::button>
    </x-slot:trigger>

    <x-aura::dropdown.item icon="pencil" wire:click="edit">Modifica</x-aura::dropdown.item>
    <x-aura::dropdown.item icon="document" wire:click="duplicate">Duplica</x-aura::dropdown.item>
    <x-aura::dropdown.separator />
    <x-aura::dropdown.item icon="trash" variant="danger" wire:click="delete">Elimina</x-aura::dropdown.item>
</x-aura::dropdown>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| position | string | 'bottom-start' | bottom-start, bottom-end, top-start, top-end |
| width | string | 'w-48' | Classe Tailwind per larghezza |
| glass | bool | false | — |

**Navigazione keyboard**: Arrow up/down, Enter per selezionare, Escape per chiudere.

#### 1.12 Tooltip
```blade
<x-aura::tooltip text="Copia negli appunti" position="top">
    <x-aura::button icon-only icon="clipboard" variant="ghost" />
</x-aura::tooltip>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| text | string | required | Testo del tooltip |
| position | string | 'top' | top, bottom, left, right |
| delay | int | 200 | Delay in ms prima di mostrare |

**Animazione**: fade-in + leggero slide dalla direzione opposta.

#### 1.13 Avatar
```blade
<x-aura::avatar src="/img/user.jpg" alt="Mario Rossi" size="lg" />
<x-aura::avatar initials="MR" size="md" color="primary" />
<x-aura::avatar src="/img/user.jpg" size="sm" status="online" />

<x-aura::avatar.group>
    <x-aura::avatar src="/img/1.jpg" />
    <x-aura::avatar src="/img/2.jpg" />
    <x-aura::avatar initials="+3" />
</x-aura::avatar.group>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| src | string | null | URL immagine |
| initials | string | null | Fallback testo (max 2 char) |
| alt | string | null | — |
| size | string | 'md' | xs, sm, md, lg, xl |
| color | string | 'primary' | Colore sfondo initials |
| status | string | null | online, offline, busy, away |
| rounded | string | 'full' | full, lg, md |

#### 1.14 Spinner / Loading
```blade
<x-aura::spinner />
<x-aura::spinner size="lg" color="primary" />
<x-aura::skeleton class="h-4 w-full" />
<x-aura::skeleton class="h-32 w-full" rounded="lg" />
```

**Spinner**: cerchio animato con gradient (non il classico border).
**Skeleton**: shimmer gradient animato (left → right).

#### 1.15 Icon System
```blade
<x-aura::icon name="check" size="md" />
```

Integrazione con **Heroicons** (default) via Blade Icons package.
Possibilita' di swap con altri icon set via config.

---

### FASE 2 — Data Display & Management
**Obiettivo**: DataTable completa che sostituisca i trait attuali, piu' componenti per visualizzazione dati.

#### 2.1 DataTable (componente core)
```blade
<x-aura::datatable
    :items="$customers"
    :columns="$columns"
    searchable
    :filters="$filters"
    :bulk-actions="$bulkActions"
    wire:sortable
    striped
    hoverable
>
    <x-slot:header-actions>
        <x-aura::button icon="plus" wire:click="create">Nuovo Cliente</x-aura::button>
    </x-slot:header-actions>

    <x-slot:column-name="name" :row="$row" inline-editable>
        {{ $row->name }}
    </x-slot:column-name>

    <x-slot:column-status="status" :row="$row">
        <x-aura::badge :variant="$row->status_color">{{ $row->status_label }}</x-aura::badge>
    </x-slot:column-status>

    <x-slot:actions :row="$row">
        <x-aura::dropdown>
            <x-aura::dropdown.item icon="pencil" wire:click="edit({{ $row->id }})">Modifica</x-aura::dropdown.item>
            <x-aura::dropdown.item icon="trash" variant="danger" wire:click="delete({{ $row->id }})">Elimina</x-aura::dropdown.item>
        </x-aura::dropdown>
    </x-slot:actions>

    <x-slot:empty>
        <x-aura::empty-state
            icon="users"
            title="Nessun cliente"
            description="Inizia aggiungendo il primo cliente."
        >
            <x-aura::button icon="plus" wire:click="create">Aggiungi Cliente</x-aura::button>
        </x-aura::empty-state>
    </x-slot:empty>
</x-aura::datatable>
```

**Trait `WithAuraDataTable`**:
```php
use BlueStarSystem\AuraUI\Traits\WithAuraDataTable;

class CustomerList extends Component
{
    use WithAuraDataTable;

    public function columns(): array
    {
        return [
            Column::make('name', 'Nome')->sortable()->searchable()->inlineEditable(),
            Column::make('email', 'Email')->sortable()->searchable(),
            Column::make('phone', 'Telefono'),
            Column::make('status', 'Stato')->sortable()->filterable([
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
            ]),
            Column::make('created_at', 'Creato il')->sortable()->date('d/m/Y'),
        ];
    }

    public function query(): Builder
    {
        return Customer::query();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('status', 'Stato')
                ->options(['active' => 'Attivo', 'inactive' => 'Inattivo']),
            DateRangeFilter::make('created_at', 'Periodo'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::make('delete', 'Elimina selezionati')
                ->icon('trash')
                ->color('danger')
                ->confirm('Eliminare i record selezionati?')
                ->action(fn ($ids) => Customer::whereIn('id', $ids)->delete()),
            BulkAction::make('export', 'Esporta CSV')
                ->icon('download')
                ->action(fn ($ids) => $this->exportCsv($ids)),
        ];
    }
}
```

**Funzionalita' DataTable**:
- [x] Search globale con debounce
- [x] Sort multi-colonna
- [x] Filtri (select, date range, boolean, text)
- [x] Paginazione completa (numeri pagina, per-page selector)
- [x] Selezione righe (singola, multipla, select-all)
- [x] Bulk actions con conferma
- [x] Inline editing (click-to-edit celle)
- [x] Column toggle (mostra/nascondi colonne)
- [x] Responsive (card view su mobile)
- [x] Export (CSV, Excel)
- [x] Empty state personalizzabile
- [x] Loading state con skeleton
- [x] Sticky header
- [x] Striped / hoverable
- [x] Row actions (dropdown per-riga)

#### 2.2 Pagination
```blade
<x-aura::pagination :paginator="$items" />
<x-aura::pagination :paginator="$items" simple />
<x-aura::pagination :paginator="$items" per-page-options="[10, 25, 50, 100]" show-info />
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| paginator | Paginator | required | Laravel paginator instance |
| simple | bool | false | Solo Prev/Next |
| per-page-options | array | [10,25,50] | Selettore righe per pagina |
| show-info | bool | true | "Mostra 1-10 di 150" |

#### 2.3 Empty State
```blade
<x-aura::empty-state
    icon="inbox"
    title="Nessun risultato"
    description="Prova a modificare i filtri di ricerca."
>
    <x-aura::button variant="primary" wire:click="resetFilters">Reset filtri</x-aura::button>
</x-aura::empty-state>
```

#### 2.4 Stats Card
```blade
<x-aura::stats-card
    title="Clienti Totali"
    value="1,234"
    change="+12%"
    change-type="positive"
    icon="users"
/>
```

#### 2.5 Progress Bar
```blade
<x-aura::progress value="75" color="primary" size="md" label animated />
<x-aura::progress :value="$progress" color="success" striped />
```

#### 2.6 Descriptive List
```blade
<x-aura::description-list>
    <x-aura::description-list.item label="Nome" value="Mario Rossi" />
    <x-aura::description-list.item label="Email">mario@example.com</x-aura::description-list.item>
</x-aura::description-list>
```

---

### FASE 3 — Form Avanzati
**Obiettivo**: Componenti form complessi con UX professionale.

#### 3.1 DatePicker
```blade
<x-aura::date-picker
    wire:model="date"
    label="Data appuntamento"
    min="{{ now()->format('Y-m-d') }}"
    format="d/m/Y"
    with-time
/>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| label | string | null | — |
| format | string | 'Y-m-d' | Formato display |
| min | string | null | Data minima |
| max | string | null | Data massima |
| with-time | bool | false | Include ora |
| range | bool | false | Selezione range |
| disabled-dates | array | [] | Date disabilitate |
| locale | string | 'it' | Localizzazione |

**Implementazione**: Alpine.js puro, NO librerie esterne. Calendar dropdown con navigazione mese/anno.

#### 3.2 TimePicker
```blade
<x-aura::time-picker wire:model="time" label="Ora" step="15" min="09:00" max="18:00" />
```

#### 3.3 File Upload
```blade
<x-aura::file-upload
    wire:model="avatar"
    label="Foto profilo"
    accept="image/*"
    max-size="2MB"
    preview
>
    <x-slot:placeholder>
        <x-aura::icon name="cloud-upload" class="w-8 h-8" />
        <span>Trascina qui o clicca per selezionare</span>
    </x-slot:placeholder>
</x-aura::file-upload>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| label | string | null | — |
| accept | string | null | MIME types |
| max-size | string | null | Limite dimensione |
| multiple | bool | false | Upload multiplo |
| preview | bool | false | Anteprima immagini |
| drag-drop | bool | true | Area drag & drop |

**Animazioni**: drag-over → border dashed animato + scale, upload → progress bar, completato → check animato.

#### 3.4 Autocomplete / Combobox
```blade
<x-aura::autocomplete
    wire:model="city"
    label="Citta'"
    :options="$cities"
    option-label="name"
    option-value="id"
    searchable
    clearable
    placeholder="Cerca citta'..."
/>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| options | array/Collection | [] | Opzioni statiche |
| wire:search | string | null | Metodo Livewire per ricerca server-side |
| option-label | string | 'label' | Chiave per label |
| option-value | string | 'value' | Chiave per value |
| searchable | bool | true | Abilita ricerca |
| clearable | bool | false | Pulsante clear |
| multiple | bool | false | Selezione multipla (pillbox) |
| create | bool | false | Permetti creazione nuove opzioni |
| min-chars | int | 0 | Caratteri minimi prima di cercare |

#### 3.5 Tags Input / Pillbox
```blade
<x-aura::tags-input
    wire:model="tags"
    label="Tags"
    :suggestions="$availableTags"
    max="10"
    placeholder="Aggiungi tag..."
/>
```

#### 3.6 Color Picker
```blade
<x-aura::color-picker wire:model="brandColor" label="Colore brand" :swatches="$presetColors" />
```

#### 3.7 Range / Slider
```blade
<x-aura::slider wire:model="price" label="Prezzo" min="0" max="1000" step="10" show-value />
<x-aura::slider wire:model="priceRange" label="Range prezzo" min="0" max="1000" range />
```

#### 3.8 OTP Input
```blade
<x-aura::otp-input wire:model="code" length="6" label="Codice verifica" />
```

#### 3.9 Rich Text Editor
```blade
<x-aura::editor
    wire:model="content"
    label="Contenuto"
    toolbar="bold,italic,link,list,heading"
    placeholder="Scrivi qui..."
/>
```

**Implementazione**: Tiptap (ProseMirror wrapper) per massima flessibilita'. Toolbar personalizzabile.

#### 3.10 Form Group & Validation UX
```blade
<x-aura::form wire:submit="save">
    <x-aura::form.section title="Informazioni personali" description="Dati base del cliente.">
        <x-aura::input label="Nome" wire:model="name" required />
        <x-aura::input label="Email" wire:model="email" type="email" required />
    </x-aura::form.section>

    <x-aura::form.section title="Preferenze">
        <x-aura::toggle wire:model="newsletter" label="Newsletter" />
    </x-aura::form.section>

    <x-aura::form.actions>
        <x-aura::button variant="ghost" href="/customers">Annulla</x-aura::button>
        <x-aura::button type="submit" loading-target="save">Salva</x-aura::button>
    </x-aura::form.actions>
</x-aura::form>
```

**Validazione real-time**: errori mostrati inline con animazione shake + glow rosso. Successo con check verde.

---

### FASE 4 — Componenti Avanzati
**Obiettivo**: Componenti complessi ad alto valore.

#### 4.1 Command Palette (Cmd+K)
```blade
<x-aura::command-palette>
    <x-aura::command-palette.group label="Navigazione">
        <x-aura::command-palette.item icon="home" label="Dashboard" href="/dashboard" />
        <x-aura::command-palette.item icon="users" label="Clienti" href="/customers" />
    </x-aura::command-palette.group>
    <x-aura::command-palette.group label="Azioni">
        <x-aura::command-palette.item icon="plus" label="Nuovo cliente" wire:click="createCustomer" />
    </x-aura::command-palette.group>
</x-aura::command-palette>
```

**Glass morphism**, full keyboard navigation, fuzzy search, sezioni raggruppate.

#### 4.2 Tabs
```blade
<x-aura::tabs wire:model="activeTab">
    <x-aura::tab name="info" label="Informazioni" icon="info-circle">
        Contenuto tab info...
    </x-aura::tab>
    <x-aura::tab name="orders" label="Ordini" icon="shopping-cart" badge="5">
        Contenuto tab ordini...
    </x-aura::tab>
</x-aura::tabs>
```

| Varianti | Descrizione |
|----------|-------------|
| default | Tabs con underline animata |
| pills | Tabs come pillole con background |
| vertical | Tabs verticali laterali |
| bordered | Tabs con bordo card |

**Animazione**: underline/background si sposta con transizione fluida verso il tab selezionato.

#### 4.3 Accordion
```blade
<x-aura::accordion>
    <x-aura::accordion.item title="Sezione 1" icon="question-circle">
        Contenuto espandibile...
    </x-aura::accordion.item>
    <x-aura::accordion.item title="Sezione 2" default-open>
        Contenuto espandibile...
    </x-aura::accordion.item>
</x-aura::accordion>
```

| Prop | Tipo | Default | Note |
|------|------|---------|------|
| multiple | bool | false | Piu' sezioni aperte contemporaneamente |
| bordered | bool | true | — |

#### 4.4 Charts
```blade
<x-aura::chart
    type="line"
    :labels="$months"
    :datasets="[
        ['label' => 'Vendite', 'data' => $salesData, 'color' => 'primary'],
        ['label' => 'Obiettivo', 'data' => $targetData, 'color' => 'secondary', 'dashed' => true],
    ]"
    height="300"
/>
```

**Tipi**: line, bar, area, pie, doughnut, mixed.
**Implementazione**: Chart.js con wrapper Alpine.js. Stile custom che segue il design system Aura.

#### 4.5 Calendar
```blade
<x-aura::calendar
    wire:model="selectedDate"
    :events="$appointments"
    :view="$calendarView"
    locale="it"
    on-event-click="showAppointment"
/>
```

**Viste**: month, week, day. Drag & drop eventi (opzionale).

#### 4.6 Kanban Board
```blade
<x-aura::kanban wire:model="columns">
    @foreach($columns as $column)
        <x-aura::kanban.column :title="$column['title']" :color="$column['color']">
            @foreach($column['items'] as $item)
                <x-aura::kanban.card :id="$item['id']">
                    {{ $item['title'] }}
                </x-aura::kanban.card>
            @endforeach
        </x-aura::kanban.column>
    @endforeach
</x-aura::kanban>
```

#### 4.7 Breadcrumbs
```blade
<x-aura::breadcrumbs :items="[
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Clienti', 'href' => '/customers'],
    ['label' => 'Mario Rossi'],
]" />
```

#### 4.8 Steps / Wizard
```blade
<x-aura::steps :current="$step">
    <x-aura::step label="Dati personali" icon="user" />
    <x-aura::step label="Indirizzo" icon="map" />
    <x-aura::step label="Conferma" icon="check" />
</x-aura::steps>
```

#### 4.9 Toast Notifications
```blade
{{-- Nel layout --}}
<x-aura::toasts position="top-right" />

{{-- Nel componente Livewire --}}
$this->dispatch('aura:toast', type: 'success', message: 'Record salvato!');
```

#### 4.10 Confirmation Dialog
```blade
<x-aura::confirms-action>
    <x-aura::button variant="danger" wire:click="delete">Elimina</x-aura::button>

    <x-slot:title>Conferma eliminazione</x-slot:title>
    <x-slot:description>Questa azione e' irreversibile.</x-slot:description>
    <x-slot:confirm>Si', elimina</x-slot:confirm>
</x-aura::confirms-action>
```

#### 4.11 Sidebar Navigation
```blade
<x-aura::sidebar collapsible>
    <x-aura::sidebar.brand>
        <img src="/logo.svg" alt="App" />
    </x-aura::sidebar.brand>

    <x-aura::sidebar.section label="Menu">
        <x-aura::sidebar.item icon="home" label="Dashboard" href="/dashboard" active />
        <x-aura::sidebar.item icon="users" label="Clienti" href="/customers" badge="12" />
        <x-aura::sidebar.item icon="cog" label="Impostazioni">
            <x-aura::sidebar.sub-item label="Profilo" href="/settings/profile" />
            <x-aura::sidebar.sub-item label="Billing" href="/settings/billing" />
        </x-aura::sidebar.item>
    </x-aura::sidebar.section>
</x-aura::sidebar>
```

#### 4.12 Tree View
```blade
<x-aura::tree :items="$categories" label-key="name" children-key="children" selectable />
```

---

## 5. Trait Livewire Riutilizzabili

| Trait | Scopo | Fase |
|-------|-------|------|
| WithAuraDataTable | Search, sort, filter, paginate | 2 |
| WithAuraFilters | Gestione filtri (state, reset, URL sync) | 2 |
| WithAuraBulkActions | Selezione multipla + azioni batch | 2 |
| WithAuraInlineEdit | Click-to-edit celle DataTable | 2 |
| WithAuraModal | Open/close modal state management | 1 |
| WithAuraToasts | Dispatch toast notifications | 4 |
| WithAuraConfirmation | Dialog di conferma prima di azioni | 4 |
| WithAuraForm | Form state, validation UX, dirty tracking | 3 |

---

## 6. Testing Strategy

### Approccio
- **Unit test** per ogni componente Blade (rendering, props, attributi)
- **Feature test** per ogni trait Livewire (interazioni, state)
- **Accessibility test** per attributi ARIA e keyboard navigation
- **Visual regression** — manuale per ora, automatizzata in futuro

### Struttura test per componente
```php
// tests/Unit/Components/ButtonTest.php
it('renders with default props', function () { ... });
it('applies variant classes', function () { ... });
it('renders as link when href is provided', function () { ... });
it('shows spinner when loading', function () { ... });
it('is disabled when disabled prop is true', function () { ... });
it('merges additional attributes', function () { ... });
it('renders icon when icon prop is provided', function () { ... });
```

### Obiettivo copertura
- Fase 0: 100% ServiceProvider, config
- Fase 1: 100% tutti i componenti primitivi
- Fase 2: 100% DataTable + trait
- Fase 3: 100% form components
- Fase 4: 90%+ componenti avanzati

---

## 7. Deliverables per Fase

| Fase | Componenti | Test stimati | Output |
|------|------------|-------------|--------|
| 0 | Package bootstrap + design system | ~15 | Package installabile |
| 1 | 15 componenti primitivi | ~120 | UI base completa |
| 2 | 6 componenti data + 4 trait | ~150 | DataTable production-ready |
| 3 | 10 componenti form | ~130 | Form builder completo |
| 4 | 12 componenti avanzati | ~160 | Libreria completa |
| **Totale** | **43 componenti + 8 trait** | **~575** | **Libreria completa** |

---

## 8. Regole di Sviluppo

1. **Ogni componente e' autocontenuto** — CSS + JS + Blade nello stesso contesto
2. **Props tipizzate** — Usare PHP 8.3+ typed properties nelle classi componenti
3. **Slot composabili** — Preferire slot a props per contenuto complesso
4. **Attributi forwarding** — Ogni componente accetta e fa merge di attributi extra
5. **Wire-compatible** — Ogni input-like component supporta `wire:model` nativamente
6. **Dark mode nativo** — Ogni componente DEVE funzionare in dark mode
7. **Accessibilita'** — ARIA labels, roles, keyboard navigation su tutto
8. **No dipendenze JS esterne** — Solo Alpine.js (+ Chart.js solo per charts, Tiptap solo per editor)
9. **CSS Variables** — Tutto personalizzabile via CSS custom properties
10. **Mobile-first** — Responsive su ogni componente
11. **Conventional Commits** — `feat:`, `fix:`, `refactor:`, `test:`, `docs:`

---

## 9. Ordine di Implementazione Dettagliato

### Sprint 1 (Fase 0 + inizio Fase 1)
1. composer.json + ServiceProvider + Config
2. CSS Design System (variabili, animazioni, shadows)
3. Tailwind Plugin
4. Install Command
5. Test setup
6. Button
7. Input
8. Textarea

### Sprint 2 (Fase 1 continua)
9. Select
10. Checkbox & Radio
11. Toggle
12. Badge
13. Alert
14. Icon System

### Sprint 3 (Fase 1 completa)
15. Card
16. Modal
17. Dropdown
18. Tooltip
19. Avatar
20. Spinner / Skeleton

### Sprint 4 (Fase 2 - DataTable)
21. Column builder class
22. WithAuraDataTable trait (search, sort)
23. WithAuraFilters trait
24. Pagination component
25. DataTable component (base)
26. WithAuraBulkActions trait
27. WithAuraInlineEdit trait
28. DataTable (completa)
29. Empty State
30. Stats Card + Progress Bar

### Sprint 5 (Fase 3 - Forms)
31. DatePicker
32. TimePicker
33. FileUpload
34. Autocomplete
35. Tags Input
36. Color Picker
37. Slider
38. OTP Input
39. Rich Text Editor (Tiptap)
40. Form Group + Validation UX

### Sprint 6 (Fase 4 - Advanced)
41. Tabs
42. Accordion
43. Command Palette
44. Toast Notifications
45. Confirmation Dialog
46. Breadcrumbs
47. Steps/Wizard
48. Sidebar Navigation
49. Charts (Chart.js)
50. Calendar
51. Kanban
52. Tree View

---

*Documento di riferimento per lo sviluppo di Aura UI. Aggiornare con progressi e decisioni.*
