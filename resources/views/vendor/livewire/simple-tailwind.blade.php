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
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4 pt-6">

            <!-- Previous Button -->
            <div>
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium text-zinc-600 bg-zinc-900/40 border border-zinc-800/50 rounded-xl cursor-not-allowed select-none">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        <span>Sebelumnya</span>
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
                                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            <span>Sebelumnya</span>
                        </button>
                    @else
                        <button type="button"
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            <span>Sebelumnya</span>
                        </button>
                    @endif
                @endif
            </div>

            <!-- Page Counter / Indicator -->
            @if (method_exists($paginator, 'currentPage'))
                <div class="text-xs text-zinc-400 font-medium tracking-wide">
                    Halaman <span class="text-white font-bold">{{ $paginator->currentPage() }}</span>
                </div>
            @endif

            <!-- Next Button -->
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
                                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200">
                            <span>Berikutnya</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </button>
                    @else
                        <button type="button"
                                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 rounded-xl hover:bg-zinc-800 hover:text-white hover:border-zinc-700 active:scale-95 transition-all duration-200">
                            <span>Berikutnya</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </button>
                    @endif
                @else
                    <span class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium text-zinc-600 bg-zinc-900/40 border border-zinc-800/50 rounded-xl cursor-not-allowed select-none">
                        <span>Berikutnya</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>

        </nav>
    @endif
</div>
