<div>
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

        {{-- pagination start --}}
        <div
            class="mt-10 text-zinc-400 [&_button]:bg-zinc-900 [&_button]:border [&_button]:border-zinc-800 [&_button]:rounded-lg [&_button]:px-4 [&_button]:py-2 [&_button:hover]:bg-zinc-800 [&_button:hover]:text-white">
            {{ $movies->links('livewire::simple-tailwind') }}
        </div>
        {{-- pagination end --}}
    @else
        <div
            class="flex flex-col items-center justify-center text-center py-20 bg-zinc-900/10 border border-dashed border-zinc-900 rounded-2xl max-w-xl mx-auto space-y-4">
            <i class="fa-solid fa-magnifying-glass text-4xl text-gray-700 animate-pulse"></i>
            <div class="space-y-1">
                <h3 class="text-base font-bold text-white">No results found</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">We couldn't find any movie matching your search.</p>
            </div>
        </div>
    @endif
</div>
