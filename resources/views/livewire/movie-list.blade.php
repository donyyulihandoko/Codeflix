<div>
    <div class="space-y-6">

        <!-- Header Section + Live Search (Style Pas dengan Dashboard) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-900 pb-3">

            <!-- Left: Title & Icon Badge -->
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-red-600/10 border border-red-500/20 rounded-lg text-red-500">
                    <i class="fa-solid fa-film text-sm sm:text-base"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide uppercase">
                        Browse Movies
                    </h2>
                    <p class="text-xs text-gray-400 hidden sm:block">
                        Eksplorasi seluruh koleksi film berkualitas tinggi secara instan
                    </p>
                </div>
            </div>

            <!-- Right: Search Input Box -->
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                </span>

                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul film..."
                    class="w-full bg-zinc-900/80 border border-zinc-800 text-gray-200 placeholder-gray-500 text-xs rounded-lg pl-9 pr-8 py-2 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200">

                <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fa-solid fa-spinner animate-spin text-red-500 text-xs"></i>
                </div>
            </div>
        </div>

        <!-- Movie Grid List -->
        @if ($movies && $movies->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-6 pt-2">
                @foreach ($movies as $movie)
                    <a href="{{ route('movies.show', $movie) }}"
                        class="group relative block rounded-lg overflow-hidden bg-zinc-900 shadow-md aspect-[2/3] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">

                        <!-- Poster Film -->
                        <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
                            alt="{{ $movie->title }} Poster" class="w-full h-full object-cover">

                        <!-- Overlay Hover (Rating & Title) -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/40 p-3 flex flex-col justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-200">

                            <!-- Top: Rating Badge -->
                            <div class="flex justify-end">
                                <div
                                    class="flex items-center gap-1 bg-black/70 backdrop-blur-md border border-yellow-500/30 text-yellow-400 text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                                    <i class="fa-solid fa-star text-[9px]"></i>
                                    <span>{{ $movie->ratings_avg_rating ? number_format($movie->ratings_avg_rating, 1) : 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Bottom: Judul & Tahun -->
                            <div>
                                <p class="font-bold text-white text-xs truncate drop-shadow">
                                    {{ $movie->title }}
                                </p>
                                <p class="text-[10px] text-gray-300">
                                    {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                                </p>
                            </div>

                        </div>

                    </a>
                @endforeach
            </div>

            <!-- Simple Pagination -->
            <div
                class="mt-8 text-zinc-400 [&_button]:bg-zinc-900 [&_button]:border [&_button]:border-zinc-800 [&_button]:rounded-lg [&_button]:px-4 [&_button]:py-2 [&_button:hover]:bg-zinc-800 [&_button:hover]:text-white">
                {{ $movies->links('livewire::simple-tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div
                class="flex flex-col items-center justify-center text-center py-16 bg-zinc-900/10 border border-dashed border-zinc-800 rounded-2xl max-w-md mx-auto space-y-3">
                <div class="p-3 bg-zinc-900/80 rounded-full border border-zinc-800 text-gray-600">
                    <i class="fa-solid fa-magnifying-glass text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-white">Film Tidak Ditemukan</h3>
                    <p class="text-xs text-gray-500 max-w-xs mx-auto">
                        Tidak ada film yang cocok dengan kata kunci pencarian kamu.
                    </p>
                </div>
            </div>
        @endif

    </div>
</div>
