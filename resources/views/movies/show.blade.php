<x-app-layout>
    <x-slot:title>{{ $movie->title }} - Streaming Premium - Codeflix</x-slot>

    <div class="w-full min-h-screen bg-zinc-950 pb-24 text-gray-200">

        <!-- Hero / Player Header Section -->
        <div class="w-full bg-black border-b border-zinc-900 shadow-2xl relative">
            <div class="max-w-6xl mx-auto aspect-video">
                <div
                    class="w-full bg-zinc-900 border-b border-zinc-800 shadow-2xl relative aspect-video max-w-6xl mx-auto flex flex-col items-center justify-center space-y-4">
                    <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-20 filter blur-[2px]">

                    <div class="relative z-10 text-center space-y-4 px-4">
                        <span
                            class="bg-red-600 text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                            Premium Content
                        </span>
                        <h2 class="text-xl sm:text-3xl font-black text-white uppercase">{{ $movie->title }}</h2>

                        <a href="{{ route('movies.watch', $movie) }}"
                            class="inline-flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-black text-xs sm:text-sm px-8 py-3.5 rounded-lg transition uppercase tracking-wider shadow-lg shadow-red-950/50">
                            <i class="fa-solid fa-play"></i>
                            <span>Mulai Menonton</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">

                <!-- Poster Left Sidebar -->
                <div class="md:col-span-3 hidden md:block">
                    <div
                        class="relative w-full aspect-[2/3] rounded-xl overflow-hidden shadow-2xl shadow-black border border-zinc-900">
                        <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : Storage::url($movie->poster) }}"
                            alt="{{ $movie->title }} Poster" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/0 pointer-events-none">
                        </div>
                    </div>
                </div>

                <!-- Main Details -->
                <div class="md:col-span-6 space-y-6">
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2 text-[11px] font-bold tracking-wide uppercase">
                            <!-- 1. Average Rating Badge Header -->
                            <div
                                class="flex items-center gap-1.5 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 px-2.5 py-0.5 rounded">
                                <i class="fa-solid fa-star text-[10px]"></i>
                                <span>{{ $movie->ratings_avg_rating ? number_format($movie->ratings_avg_rating, 1) : 'N/A' }}</span>
                                <span class="text-zinc-500 font-normal">/ 5.0</span>
                            </div>

                            <span class="bg-red-600/10 text-red-500 border border-red-500/20 px-2 py-0.5 rounded">
                                <i class="fa-solid fa-video mr-1"></i> {{ $movie->url_4k ? '4K Ultra' : 'Full HD' }}
                            </span>
                            <span class="bg-zinc-900 border border-zinc-800 text-gray-400 px-2 py-0.5 rounded">
                                {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}m
                            </span>
                            <span class="bg-zinc-900 border border-zinc-800 text-gray-400 px-2 py-0.5 rounded">
                                {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                            </span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight uppercase leading-tight">
                            {{ $movie->title }}
                        </h1>
                    </div>

                    <div class="space-y-2">
                        <h3
                            class="text-xs font-bold text-gray-500 uppercase tracking-widest border-b border-zinc-900 pb-1.5">
                            Synopsis
                        </h3>
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                            {{ $movie->description }}
                        </p>
                    </div>

                    <div class="space-y-3 pt-2">
                        <div
                            class="text-xs sm:text-sm grid grid-cols-12 border-b border-zinc-900/60 pb-2.5 items-center">
                            <!-- Label / Header -->
                            <span class="col-span-3 text-zinc-500 font-semibold uppercase tracking-wider text-[11px]">
                                Director
                            </span>

                            <!-- Value List (Interactive Link) -->
                            <div class="col-span-9 flex flex-wrap gap-x-1 text-zinc-300">
                                @forelse ($movie->directors as $director)
                                    <a href="{{ route('crews.show', $director) }}"
                                        class="hover:text-blue-500 hover:underline transition-colors duration-150">
                                        {{ $director->name }}
                                    </a>{{ !$loop->last ? ',' : '' }}
                                @empty
                                    <span class="text-zinc-600 font-normal italic">-</span>
                                @endforelse
                            </div>
                        </div>

                        <div
                            class="text-xs sm:text-sm grid grid-cols-12 border-b border-zinc-900/60 pb-2.5 items-center">
                            <!-- Label / Header -->
                            <span class="col-span-3 text-zinc-500 font-semibold uppercase tracking-wider text-[11px]">
                                WRITERS
                            </span>

                            <!-- Value List (Interactive Link) -->
                            <div class="col-span-9 flex flex-wrap gap-x-1 text-zinc-300">
                                @forelse ($movie->writers as $writer)
                                    <a href="{{ route('crews.show', $writer) }}"
                                        class="hover:text-blue-500 hover:underline transition-colors duration-150">
                                        {{ $writer->name }}
                                    </a>{{ !$loop->last ? ',' : '' }}
                                @empty
                                    <span class="text-zinc-600 font-normal italic">-</span>
                                @endforelse
                            </div>
                        </div>

                        <div
                            class="text-xs sm:text-sm grid grid-cols-12 border-b border-zinc-900/60 pb-2.5 items-center">
                            <!-- Label / Header -->
                            <span class="col-span-3 text-zinc-500 font-semibold uppercase tracking-wider text-[11px]">
                                STARS
                            </span>

                            <!-- Value List (Interactive Link) -->
                            <div class="col-span-9 flex flex-wrap gap-x-1 text-zinc-300">
                                @forelse ($movie->stars as $star)
                                    <a href="{{ route('crews.show', $star) }}"
                                        class="hover:text-blue-500 hover:underline text-red-500/90 transition-colors duration-150">
                                        {{ $star->name }}
                                    </a>{{ !$loop->last ? ',' : '' }}
                                @empty
                                    <span class="text-zinc-600 font-normal italic">-</span>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-2">
                            <div>
                                <span class="text-gray-550 block font-semibold mb-0.5">Genres:</span>
                                <span
                                    class="text-gray-300">{{ $movie->categories->pluck('title')->implode(', ') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-550 block font-semibold mb-0.5">Audio Quality:</span>
                                <span class="text-gray-300">Dolby Digital 5.1 (Surround)</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-gray-550 block font-semibold mb-0.5">Stream Quality:</span>
                                <span class="text-green-500 font-bold flex items-center">
                                    <i class="fa-solid fa-circle text-[6px] mr-1.5 animate-pulse"></i> 1080p Full HD
                                    Enabled
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-550 block font-semibold mb-0.5">Subtitles:</span>
                                <span class="text-gray-300">Bahasa Indonesia, English (CC)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Actions -->
                <div class="md:col-span-3 space-y-4">

                    <!-- 2. Display-Only Rating Card -->
                    <div
                        class="bg-zinc-900/40 border border-zinc-900 p-5 rounded-xl space-y-3 shadow-xl backdrop-blur-sm text-xs">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center">
                                    <i class="fa-solid fa-star mr-2 text-yellow-500"></i> Audience Score
                                </h3>
                                <p class="text-[11px] text-gray-500 mt-0.5">Based on user ratings</p>
                            </div>

                            <div class="text-right">
                                <span class="text-2xl font-black text-white">
                                    {{ $movie->ratings_avg_rating ? number_format($movie->ratings_avg_rating, 1) : '0.0' }}
                                </span>
                                <span class="text-[10px] text-gray-500">/ 5</span>
                            </div>
                        </div>

                        <!-- Star Representation -->
                        <div class="pt-2 border-t border-zinc-800/80 flex items-center justify-between text-yellow-500">
                            <div class="flex items-center gap-1">
                                @php $avg = round($movie->ratings_avg_rating ?? 0); @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $avg ? 'solid' : 'regular' }} fa-star text-xs"></i>
                                @endfor
                            </div>
                            <span class="text-[10px] text-gray-400 font-medium">
                                {{ $movie->ratings_count ?? 0 }} {{ Str::plural('vote', $movie->ratings_count ?? 0) }}
                            </span>
                        </div>
                    </div>

                    <!-- Streaming Status Card -->
                    <div
                        class="bg-zinc-900/40 border border-zinc-900 p-5 rounded-xl space-y-4 shadow-xl backdrop-blur-sm text-xs">
                        <div class="space-y-1">
                            <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center">
                                <i class="fa-solid fa-id-card mr-2 text-red-500"></i> Streaming Status
                            </h3>
                            <p class="text-[11px] text-gray-500">You are currently watching with active membership
                                access.</p>
                        </div>

                        <div class="pt-2 border-t border-zinc-800 space-y-2">
                            <form action="{{ route('mylists.store', $movie) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center space-x-2 bg-zinc-900 hover:bg-zinc-800 text-gray-300 font-bold p-2.5 rounded-lg border border-zinc-800 transition">
                                    <i class="fa-solid fa-bookmark text-gray-400 text-[11px]"></i>
                                    <span>Add to My List</span>
                                </button>
                            </form>

                            <button
                                class="w-full flex items-center justify-center space-x-2 bg-zinc-900/10 hover:bg-zinc-900 text-gray-500 hover:text-red-400 font-semibold p-2.5 rounded-lg transition text-[11px]">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Report Stream Issue</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
