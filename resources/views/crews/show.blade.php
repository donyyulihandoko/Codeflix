<x-app-layout>
    <div class="min-h-screen bg-black text-zinc-100 pb-16 pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-6 text-xs text-zinc-400">
                <a href="{{ route('dashboard') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2 text-zinc-600">/</span>
                <span class="text-zinc-200 font-semibold">{{ $crew->name }}</span>
            </nav>

            <!-- Profile Header Section -->
            <div
                class="flex flex-col md:flex-row gap-8 items-start mb-12 bg-zinc-900/60 p-6 md:p-8 rounded-2xl border border-zinc-800/80 backdrop-blur-sm">

                <!-- Avatar / Photo -->
                <div
                    class="w-36 h-36 md:w-48 md:h-48 flex-shrink-0 rounded-2xl overflow-hidden bg-zinc-800 border-2 border-zinc-700/50 shadow-xl relative">
                    @if ($crew->photo)
                        <img src="{{ Str::startsWith($crew->photo, 'http') ? $crew->photo : Storage::url($crew->photo) }}"
                            alt="{{ $crew->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-zinc-600">
                            <i class="fa-solid fa-user text-5xl mb-2"></i>
                            <span class="text-xs">No Photo</span>
                        </div>
                    @endif
                </div>

                <!-- Info Details -->
                <div class="flex-1 space-y-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white mb-2">
                            {{ $crew->name }}
                        </h1>

                        <!-- Badges Roles -->
                        <div class="flex flex-wrap gap-2">
                            @if ($crew->directedMovies->isNotEmpty())
                                <span
                                    class="px-2.5 py-1 text-xs font-medium rounded-md bg-red-950/60 text-red-400 border border-red-800/50">
                                    <i class="fa-solid fa-clapperboard mr-1 text-[10px]"></i> Director
                                </span>
                            @endif
                            @if ($crew->writtenMovies->isNotEmpty())
                                <span
                                    class="px-2.5 py-1 text-xs font-medium rounded-md bg-amber-950/60 text-amber-400 border border-amber-800/50">
                                    <i class="fa-solid fa-pen-nib mr-1 text-[10px]"></i> Writer
                                </span>
                            @endif
                            @if ($crew->starredMovies->isNotEmpty())
                                <span
                                    class="px-2.5 py-1 text-xs font-medium rounded-md bg-blue-950/60 text-blue-400 border border-blue-800/50">
                                    <i class="fa-solid fa-star mr-1 text-[10px]"></i> Cast / Star
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Meta Information (Birth, Place) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs border-t border-zinc-800/80">
                        @if ($crew->birth_date)
                            <div class="flex items-center gap-2 text-zinc-400">
                                <i class="fa-regular fa-calendar text-zinc-500 w-4"></i>
                                <span>Lahir: <strong
                                        class="text-zinc-200">{{ \Carbon\Carbon::parse($crew->birth_date)->translatedFormat('d F Y') }}</strong></span>
                            </div>
                        @endif

                        @if ($crew->place_of_birth)
                            <div class="flex items-center gap-2 text-zinc-400">
                                <i class="fa-solid fa-location-dot text-zinc-500 w-4"></i>
                                <span>Tempat Lahir: <strong
                                        class="text-zinc-200">{{ $crew->place_of_birth }}</strong></span>
                            </div>
                        @endif
                    </div>

                    <!-- Biography -->
                    @if ($crew->biography)
                        <div class="pt-2">
                            <h3 class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Biografi</h3>
                            <p class="text-sm text-zinc-300 leading-relaxed whitespace-pre-line line-clamp-4 hover:line-clamp-none transition-all duration-300 cursor-pointer"
                                title="Klik untuk membaca selengkapnya">
                                {{ $crew->biography }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Filmography Section -->
            <div class="space-y-12">

                {{-- Directing Movies --}}
                @if ($crew->directedMovies->isNotEmpty())
                    <section>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-1 h-5 bg-red-600 rounded-full"></div>
                            <h2 class="text-xl font-bold text-white tracking-wide">Disutradarai Oleh {{ $crew->name }}
                            </h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($crew->directedMovies as $movie)
                                <x-movie-card :movie="$movie" />
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Written Movies --}}
                @if ($crew->writtenMovies->isNotEmpty())
                    <section>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                            <h2 class="text-xl font-bold text-white tracking-wide">Naskah Ditulis Oleh
                                {{ $crew->name }}</h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($crew->writtenMovies as $movie)
                                <x-movie-card :movie="$movie" />
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Starred Movies --}}
                @if ($crew->starredMovies->isNotEmpty())
                    <section>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
                            <h2 class="text-xl font-bold text-white tracking-wide">Dibintangi Oleh {{ $crew->name }}
                            </h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($crew->starredMovies as $movie)
                                <x-movie-card :movie="$movie" />
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
