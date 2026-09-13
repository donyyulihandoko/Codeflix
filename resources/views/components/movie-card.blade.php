@props(['movie'])

<div
    {{ $attributes->merge(['class' => 'group relative rounded-xl overflow-hidden bg-zinc-900 shadow-md aspect-[2/3] transition-all duration-300 hover:scale-105 hover:z-30 border border-zinc-800 hover:border-zinc-700 hover:shadow-xl hover:shadow-black/60']) }}>

    <!-- Movie Poster Image -->
    <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
        alt="{{ $movie->title }} Poster"
        class="object-cover w-full h-full transition-all duration-300 group-hover:brightness-50" loading="lazy">

    <!-- Hover Overlay Content -->
    <div
        class="absolute inset-0 flex flex-col justify-between p-4 text-xs transition-opacity duration-300 opacity-0 group-hover:opacity-100 bg-gradient-to-t from-black/95 via-black/80 to-transparent">

        <!-- Top Section: Title & Description -->
        <div class="pt-2 space-y-2">
            <h3 class="text-sm font-extrabold leading-snug tracking-wider text-white uppercase truncate">
                {{ $movie->title }}
            </h3>

            @if ($movie->description)
                <p class="text-zinc-400 text-[11px] leading-relaxed line-clamp-4 font-normal">
                    {{ $movie->description }}
                </p>
            @endif
        </div>

        <!-- Bottom Section: Meta Data & Action Button -->
        <div class="pt-3 space-y-3 border-t border-zinc-800/80">

            <!-- Metadata: Duration & Release Year -->
            <div class="flex items-center justify-between text-zinc-400 font-semibold text-[11px]">
                @if ($movie->duration)
                    <span class="bg-zinc-800/90 text-zinc-300 px-2 py-0.5 rounded-md border border-zinc-700/50">
                        <i class="fa-regular fa-clock text-[10px] mr-1 text-zinc-400"></i>{{ $movie->duration }} Min
                    </span>
                @endif

                @if ($movie->release_date)
                    <span class="text-zinc-400">
                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                    </span>
                @endif
            </div>

            <!-- Play Button -->
            <a href="{{ route('movies.show', $movie) }}"
                class="flex items-center justify-center w-full py-2 space-x-2 font-bold text-center text-white transition-colors duration-150 bg-red-600 rounded-lg shadow-md hover:bg-red-700 shadow-red-950/50">
                <i class="fa-solid fa-play text-[10px]"></i>
                <span>Watch Now</span>
            </a>
        </div>

    </div>

</div>
