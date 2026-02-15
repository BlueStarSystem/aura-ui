@props([
    'paginator' => null,
    'simple' => false,
    'perPageOptions' => [10, 25, 50, 100],
    'showInfo' => true,
    'showPerPage' => true,
])

@if($paginator && $paginator->hasPages())
<nav class="aura-pagination" role="navigation" aria-label="Navigazione pagine">
    <div class="aura-pagination-info-row">
        @if($showInfo)
            <div class="aura-pagination-info">
                Mostra <strong>{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</strong>
                di <strong>{{ $paginator->total() }}</strong> risultati
            </div>
        @endif

        @if($showPerPage && !$simple)
            <div class="aura-pagination-per-page">
                <label class="aura-pagination-per-page-label">Righe:</label>
                <select class="aura-select aura-input-sm aura-pagination-per-page-select" wire:model.live="perPage">
                    @foreach($perPageOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <div class="aura-pagination-buttons">
        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <span class="aura-pagination-btn aura-pagination-btn-disabled" aria-disabled="true">
                <x-aura::icon name="chevron-left" size="sm" />
            </span>
        @else
            <button class="aura-pagination-btn" wire:click="previousPage" rel="prev" aria-label="Precedente">
                <x-aura::icon name="chevron-left" size="sm" />
            </button>
        @endif

        @unless($simple)
            {{-- Page Numbers --}}
            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="aura-pagination-btn aura-pagination-btn-active" aria-current="page">{{ $page }}</span>
                @elseif($page == 1 || $page == $paginator->lastPage() || abs($page - $paginator->currentPage()) <= 1)
                    <button class="aura-pagination-btn" wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                @elseif(abs($page - $paginator->currentPage()) == 2)
                    <span class="aura-pagination-ellipsis">...</span>
                @endif
            @endforeach
        @endunless

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <button class="aura-pagination-btn" wire:click="nextPage" rel="next" aria-label="Successiva">
                <x-aura::icon name="chevron-right" size="sm" />
            </button>
        @else
            <span class="aura-pagination-btn aura-pagination-btn-disabled" aria-disabled="true">
                <x-aura::icon name="chevron-right" size="sm" />
            </span>
        @endif
    </div>
</nav>
@endif
