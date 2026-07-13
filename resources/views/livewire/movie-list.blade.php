<div>
    <div class="space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-900 pb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide uppercase">
                    Browse Movies
                </h2>
                <p class="text-xs text-gray-500 mt-1">Discover elite streaming content instantly.</p>
            </div>

            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search movie titles..."
                    class="w-full bg-zinc-900/60 border border-zinc-800 text-gray-200 placeholder-gray-500 text-xs rounded-lg pl-10 pr-4 py-2.5 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200">

                <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fa-solid fa-spinner animate-spin text-red-500 text-xs"></i>
                </div>
            </div>
        </div>

        @if ($movies && $movies->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-5 gap-y-8">
                @foreach ($movies as $movie)
                    <div
                        class="group relative rounded-lg overflow-hidden bg-zinc-900 shadow-md aspect-[2/3] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">

                        <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
                            alt="{{ $movie->title }} Poster" class="w-full h-full object-cover">

                        <div
                            class="absolute inset-0 bg-black/90 p-4 opacity-0 group-hover:opacity-100 flex flex-col justify-between transition-opacity duration-250 text-xs">
                            <div class="space-y-2">
                                <div class="font-black text-white text-sm truncate uppercase tracking-wide">
                                    {{ $movie->title }}
                                </div>
                                <p class="text-gray-400 text-[11px] leading-relaxed line-clamp-5">
                                    {{ $movie->description }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-zinc-800/80 space-y-3">
                                <div class="flex items-center justify-between text-gray-400 font-bold text-[11px]">
                                    <span class="bg-zinc-800 px-1.5 py-0.5 rounded text-gray-300">
                                        {{ $movie->duration }} Min
                                    </span>
                                    <span>
                                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                                    </span>
                                </div>

                                <a href="{{ route('movies.show', $movie) }}"
                                    class="w-full flex items-center justify-center space-x-1.5 bg-white hover:bg-gray-200 text-black font-extrabold py-2 rounded text-center transition duration-150">
                                    <i class="fa-solid fa-play text-[10px]"></i>
                                    <span>Play Now</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            @if ($movies->hasPages())
                <div class="pt-10 border-t border-zinc-900 flex items-center justify-between text-xs font-bold">
                    <div class="text-gray-500 font-medium">
                        Page {{ $movies->currentPage() }} of {{ $movies->lastPage() }}
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Tombol Previous --}}
                        @if ($movies->onFirstPage())
                            <button
                                class="bg-zinc-900/40 text-gray-600 cursor-not-allowed border border-zinc-900 px-4 py-2 rounded-md transition"
                                disabled>
                                <i class="fa-solid fa-chevron-left mr-1 text-[10px]"></i> Prev
                            </button>
                        @else
                            <button wire:click="previousPage"
                                class="bg-zinc-900 hover:bg-zinc-800 text-gray-300 hover:text-white border border-zinc-800 px-4 py-2 rounded-md transition duration-150">
                                <i class="fa-solid fa-chevron-left mr-1 text-[10px]"></i> Prev
                            </button>
                        @endif

                        {{-- Tombol Next --}}
                        @if ($movies->hasMorePages())
                            <button wire:click="nextPage"
                                class="bg-zinc-900 hover:bg-zinc-800 text-gray-300 hover:text-white border border-zinc-800 px-4 py-2 rounded-md transition duration-150">
                                Next <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                            </button>
                        @else
                            <button
                                class="bg-zinc-900/40 text-gray-600 cursor-not-allowed border border-zinc-900 px-4 py-2 rounded-md transition"
                                disabled>
                                Next <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <div
                class="flex flex-col items-center justify-center text-center py-20 bg-zinc-900/10 border border-dashed border-zinc-900 rounded-2xl max-w-xl mx-auto space-y-4">
                <i class="fa-solid fa-magnifying-glass text-4xl text-gray-700 animate-pulse"></i>
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-white">No results found</h3>
                    <p class="text-xs text-gray-500 max-w-xs mx-auto">We couldn't find any movie matching your search.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
