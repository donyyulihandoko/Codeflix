@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
        (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between pt-4">

            <!-- Previous Page Link -->
            <div>
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-zinc-600 bg-zinc-900/40 border border-zinc-800/60 rounded-xl cursor-not-allowed opacity-60">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>{!! __('pagination.previous') !!}</span>
                    </span>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        @php($previousCursor = $paginator->previousCursor() ?? $paginator->cursor())
                        <button type="button"
                                dusk="previousPage"
                                wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $previousCursor?->encode() }}"
                                wire:click="setPage('{{ $previousCursor?->encode() }}','{{ $paginator->getCursorName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-red-600">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i>
                            <span>{!! __('pagination.previous') !!}</span>
                        </button>
                    @else
                        <button type="button"
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-red-600">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i>
                            <span>{!! __('pagination.previous') !!}</span>
                        </button>
                    @endif
                @endif
            </div>

            <!-- Page Indicator Status (Opsional, Menambah Info Halaman) -->
            <div class="hidden sm:flex items-center gap-1.5 text-xs text-zinc-500 font-medium">
                <span>Halaman</span>
                <span class="text-zinc-200 font-bold px-2 py-0.5 bg-zinc-900 border border-zinc-800 rounded-lg">
                    {{ $paginator->currentPage() }}
                </span>
            </div>

            <!-- Next Page Link -->
            <div>
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        @php($nextCursor = $paginator->nextCursor() ?? $paginator->cursor())
                        <button type="button"
                                dusk="nextPage"
                                wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $nextCursor?->encode() }}"
                                wire:click="setPage('{{ $nextCursor?->encode() }}','{{ $paginator->getCursorName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-red-600">
                            <span>{!! __('pagination.next') !!}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    @else
                        <button type="button"
                                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-red-600">
                            <span>{!! __('pagination.next') !!}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    @endif
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-zinc-600 bg-zinc-900/40 border border-zinc-800/60 rounded-xl cursor-not-allowed opacity-60">
                        <span>{!! __('pagination.next') !!}</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                @endif
            </div>

        </nav>
    @endif
</div>
