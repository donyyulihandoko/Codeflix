<x-app-layout>
    <x-slot:title>Home - Codeflix Streaming</x-slot>

    @if ($heroMovie)
        <div
            class="relative w-full min-h-[50vh] sm:h-[65vh] bg-zinc-950 flex items-center px-4 sm:px-12 lg:px-20 overflow-hidden border-b border-zinc-900">

            <div
                class="absolute right-0 top-0 w-[500px] h-[500px] bg-red-900/10 rounded-full blur-[120px] pointer-events-none">
            </div>
            <div
                class="absolute left-1/3 bottom-0 w-[300px] h-[300px] bg-zinc-900/40 rounded-full blur-[80px] pointer-events-none">
            </div>

            <div class="relative z-10 w-full grid grid-cols-1 md:grid-cols-12 gap-8 items-center py-8">

                <div class="md:col-span-7 space-y-4 text-left">
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded bg-red-600/10 border border-red-500/20 text-xs font-bold text-red-500 uppercase tracking-widest">
                        <i class="fa-solid fa-bolt mr-1.5 text-[10px]"></i> New Spotlight
                    </span>

                    <h1
                        class="text-3xl sm:text-5xl font-black tracking-tight text-white uppercase leading-tight drop-shadow">
                        {{ $heroMovie->title }}
                    </h1>

                    <p class="text-sm sm:text-base text-gray-400 leading-relaxed max-w-xl line-clamp-3">
                        {{ $heroMovie->description }}
                    </p>

                    <div class="flex items-center space-x-3 pt-2">
                        <a href="{{ route('movies.show', $heroMovie) }}"
                            class="flex items-center space-x-2 bg-red-650 hover:bg-red-700 text-white font-extrabold px-6 py-3 rounded-md shadow-lg shadow-red-900/20 transition duration-200 text-sm hover:scale-102">
                            <i class="fa-solid fa-play text-base"></i>
                            <span>Watch Stream</span>
                        </a>
                        <span
                            class="text-xs text-gray-500 font-semibold border border-zinc-800 px-2.5 py-1.5 rounded bg-zinc-900/50">
                            {{ $heroMovie->duration }} Minutes
                        </span>
                    </div>
                </div>

                <div class="hidden md:flex md:col-span-5 justify-center lg:justify-end">
                    <div
                        class="relative w-48 lg:w-64 aspect-[2/3] rounded-lg overflow-hidden shadow-2xl shadow-black border border-zinc-800 transform rotate-2 hover:rotate-0 transition duration-300 group">

                        <img src="{{ Str::startsWith($heroMovie->poster, 'http') ? $heroMovie->poster : Storage::url($heroMovie->poster) }}"
                            alt="{{ $heroMovie->title }}" class="w-full h-full object-cover">

                        <div class="absolute inset-0 border border-white/10 rounded-lg pointer-events-none"></div>
                    </div>
                </div>

            </div>
        </div>
    @else
        <div class="h-[15vh] bg-zinc-950"></div>
    @endif



    <div class="px-4 sm:px-12 lg:px-20 pb-20 mt-12 sm:mt-20 relative z-20 space-y-16">

        <div class="space-y-5">
            <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
                <a href="{{ route('movies.index') }}">
                    <h2
                        class="text-xl sm:text-2xl font-black text-white tracking-wide hover:text-red-500 cursor-pointer transition inline-flex items-center group">
                        Browse Movies
                        <i
                            class="fa-solid fa-chevron-right text-xs ml-2.5 opacity-0 group-hover:opacity-100 transition duration-200"></i>
                    </h2>
                </a>
                <span class="text-xs text-gray-500 font-medium hidden sm:inline">Showing all available streams</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5 pt-2">
                @foreach ($trendingMovies as $movie)
                    <a href="{{ route('movies.show', $movie) }}">
                        <div
                            class="group relative rounded-md overflow-hidden bg-zinc-900 cursor-pointer shadow-lg aspect-[2/3] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">

                            <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
                                alt="{{ $movie->title }}" class="w-full h-full object-cover">

                            <div
                                class="absolute inset-0 bg-black/85 p-4 opacity-0 group-hover:opacity-100 flex flex-col justify-between transition-opacity duration-200 text-xs">
                                <div class="space-y-1">
                                    <div class="font-bold text-white truncate text-sm">{{ $movie->title }}</div>
                                    <div class="text-gray-400 text-[11px] line-clamp-4 leading-relaxed">
                                        {{ $movie->description }}</div>
                                </div>

                                <div
                                    class="pt-2 border-t border-zinc-800/80 flex items-center justify-between text-gray-400 font-semibold">
                                    <span
                                        class="bg-zinc-800 px-1.5 py-0.5 rounded text-[10px] text-gray-300">{{ $movie->duration }}
                                        Min</span>
                                    <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                                </div>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
