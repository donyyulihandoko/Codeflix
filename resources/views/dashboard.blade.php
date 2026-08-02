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

        <!-- 1. Section: Trending Movies -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-red-600/10 border border-red-500/20 rounded-lg text-red-500">
                        <i class="fa-solid fa-fire text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide uppercase">
                            Trending Now
                        </h2>
                        <p class="text-xs text-gray-400 hidden sm:block">
                            Film yang paling banyak ditonton dan hangat dibicarakan minggu ini
                        </p>
                    </div>
                </div>

                <a href="{{ route('movies.index') }}"
                    class="text-xs text-gray-400 hover:text-white font-semibold transition inline-flex items-center group">
                    <span>Lihat Semua</span>
                    <i
                        class="fa-solid fa-chevron-right text-[10px] ml-1.5 transform group-hover:translate-x-1 transition"></i>
                </a>
            </div>

            <x-trending-movies :trendingMovies="$trendingMovies" />
        </section>

        <!-- 2. Section: Top Rated Movies -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-yellow-500/10 border border-yellow-500/20 rounded-lg text-yellow-400">
                        <i class="fa-solid fa-trophy text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide uppercase">
                            Top Rated Movies
                        </h2>
                        <p class="text-xs text-gray-400 hidden sm:block">
                            Koleksi film dengan penilaian tertinggi pilihan penonton
                        </p>
                    </div>
                </div>

                <a href="{{ route('movies.index') }}"
                    class="text-xs text-gray-400 hover:text-white font-semibold transition inline-flex items-center group">
                    <span>Lihat Semua</span>
                    <i
                        class="fa-solid fa-chevron-right text-[10px] ml-1.5 transform group-hover:translate-x-1 transition"></i>
                </a>
            </div>

            <x-top-rate-movies :topRateMovies="$topRateMovies" />
        </section>

        <!-- 3. Section: New Release Movies -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-400">
                        <i class="fa-solid fa-bolt text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide uppercase">
                            New Releases
                        </h2>
                        <p class="text-xs text-gray-400 hidden sm:block">
                            Film terbaru yang baru saja ditambahkan ke katalog
                        </p>
                    </div>
                </div>

                <a href="{{ route('movies.index') }}"
                    class="text-xs text-gray-400 hover:text-white font-semibold transition inline-flex items-center group">
                    <span>Lihat Semua</span>
                    <i
                        class="fa-solid fa-chevron-right text-[10px] ml-1.5 transform group-hover:translate-x-1 transition"></i>
                </a>
            </div>

            <x-new-release-movies :newReleaseMovies="$newReleaseMovies" />
        </section>

    </div>



</x-app-layout>
