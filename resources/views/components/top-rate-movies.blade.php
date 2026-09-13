<div>
    @if ($topRateMovies && $topRateMovies->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-5 gap-y-8">
            @foreach ($topRateMovies as $movie)
                <a href="{{ route('movies.show', $movie) }}"
                    class="group relative block rounded-lg overflow-hidden bg-zinc-900 shadow-md aspect-[2/3] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">

                    <!-- Poster Film -->
                    <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
                        alt="{{ $movie->title }} Poster" class="w-full h-full object-cover">

                    <!-- Overlay Tipis Saat Hover + Badge Rating & Judul Singkat -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/40 p-3 flex flex-col justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-200">

                        <!-- Top: Rating Badge -->
                        <div class="flex justify-end">

                            <div
                                class="flex items-center gap-1 bg-black/70 backdrop-blur-md border border-yellow-500/30 text-yellow-400 text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                                <i class="fa-solid fa-star text-[9px]"></i>
                                <span>
                                    {{ $movie->ratings_avg_rating ? number_format($movie->ratings_avg_rating, 1) : 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Bottom: Judul Film Singkat -->
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
    @else
        <div
            class="flex flex-col items-center justify-center text-center py-20 bg-zinc-900/10 border border-dashed border-zinc-900 rounded-2xl max-w-xl mx-auto space-y-4">
            <i class="fa-solid fa-magnifying-glass text-4xl text-gray-700 animate-pulse"></i>
            <div class="space-y-1">
                <h3 class="text-base font-bold text-white">No results found</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">We couldn't find any movie matching your
                    search.</p>
            </div>
        </div>
    @endif
</div>
