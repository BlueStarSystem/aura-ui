@props([
    'paginator' => null,
    'simple' => false,
    'perPageOptions' => [10, 25, 50, 100],
    'showInfo' => true,
    'showPerPage' => true,
])

@if($paginator && $paginator->total() > 0)
<nav class="aura-pagination flex flex-col gap-3" role="navigation" aria-label="Navigazione pagine">
    <div class="aura-pagination-info-row flex items-center justify-between flex-wrap gap-2 text-[13px] text-aura-surface-500">
        @if($showInfo)
            <div class="aura-pagination-info">
                Mostra <strong>{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</strong>
                di <strong>{{ $paginator->total() }}</strong> risultati
            </div>
        @endif

        @if($showPerPage && !$simple)
            <div class="aura-pagination-per-page flex items-center gap-1.5">
                <label class="aura-pagination-per-page-label text-[13px] text-aura-surface-500 whitespace-nowrap">Righe:</label>
                <select class="aura-select aura-input-sm aura-pagination-per-page-select w-auto min-w-[60px] py-1 px-2 pr-6 text-[13px] border border-aura-surface-300 rounded-aura-md bg-aura-surface-0 text-aura-surface-900" wire:model.live="perPage">
                    @foreach($perPageOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    @if($paginator->hasPages())
    <div class="aura-pagination-buttons flex items-center justify-center gap-1 flex-wrap">
        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <span class="aura-pagination-btn aura-pagination-btn-disabled inline-flex items-center justify-center min-w-[32px] h-8 px-1.5 border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 text-[13px] font-medium opacity-40 cursor-not-allowed" aria-disabled="true">
                <x-aura::icon name="chevron-left" size="sm" />
            </span>
        @else
            <button class="aura-pagination-btn inline-flex items-center justify-center min-w-[32px] h-8 px-1.5 border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 text-[13px] font-medium cursor-pointer aura-transition-fast hover:bg-aura-surface-50 hover:border-aura-primary-200 hover:text-aura-primary-600 hover:shadow-aura-sm" wire:click="previousPage" rel="prev" aria-label="Precedente">
                <x-aura::icon name="chevron-left" size="sm" />
            </button>
        @endif

        @unless($simple)
            {{-- Page Numbers --}}
            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="aura-pagination-btn aura-pagination-btn-active inline-flex items-center justify-center min-w-[32px] h-8 px-1.5 border border-aura-primary-500 rounded-aura-md bg-aura-primary-500 text-white text-[13px] font-medium shadow-[var(--aura-glow-primary)]" aria-current="page">{{ $page }}</span>
                @elseif($page == 1 || $page == $paginator->lastPage() || abs($page - $paginator->currentPage()) <= 1)
                    <button class="aura-pagination-btn inline-flex items-center justify-center min-w-[32px] h-8 px-1.5 border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 text-[13px] font-medium cursor-pointer aura-transition-fast hover:bg-aura-surface-50 hover:border-aura-primary-200 hover:text-aura-primary-600 hover:shadow-aura-sm" wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                @elseif(abs($page - $paginator->currentPage()) == 2)
                    <span class="aura-pagination-ellipsis inline-flex items-center justify-center min-w-[32px] h-8 text-aura-surface-400 text-[13px] select-none">...</span>
                @endif
            @endforeach
        @endunless

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <button class="aura-pagination-btn inline-flex items-center justify-center min-w-[32px] h-8 px-1.5 border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 text-[13px] font-medium cursor-pointer aura-transition-fast hover:bg-aura-surface-50 hover:border-aura-primary-200 hover:text-aura-primary-600 hover:shadow-aura-sm" wire:click="nextPage" rel="next" aria-label="Successiva">
                <x-aura::icon name="chevron-right" size="sm" />
            </button>
        @else
            <span class="aura-pagination-btn aura-pagination-btn-disabled inline-flex items-center justify-center min-w-[32px] h-8 px-1.5 border border-aura-surface-200 rounded-aura-md bg-aura-surface-0 text-aura-surface-900 text-[13px] font-medium opacity-40 cursor-not-allowed" aria-disabled="true">
                <x-aura::icon name="chevron-right" size="sm" />
            </span>
        @endif
    </div>
    @endif
</nav>
@endif
