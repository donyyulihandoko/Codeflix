<x-app-layout>
    <x-slot:title>Watching {{ $movie->title }} - Codeflix Premium</x-slot>

    <div class="w-full min-h-screen bg-zinc-950 pb-24 text-gray-200">

        <!-- ─── 1. CINEMATIC THEATER VIDEO PLAYER CONTAINER ─── -->
        <div class="w-full bg-black border-b border-zinc-900 shadow-2xl relative">
            <div class="max-w-6xl mx-auto aspect-video relative group">

                <!-- Floating Back Button -->
                <div
                    class="absolute top-4 left-4 z-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="{{ route('movies.show', $movie) }}"
                        class="flex items-center space-x-2 bg-zinc-950/80 hover:bg-zinc-900 border border-zinc-800 text-gray-300 hover:text-white px-3 py-2 rounded-lg text-xs font-bold backdrop-blur-md transition shadow-lg">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Back to Details</span>
                    </a>
                </div>

                @if ($subscription->plan->resolution === '720p')
                    <!-- Iframe Video Player Utama -->
                    <iframe id="video-player" src="{{ $movie->url_720 }}" class="w-full h-full shadow-inner"
                        allowfullscreen allow="autoplay; encrypted-media; picture-in-picture">
                    </iframe>
                @elseif ($subscription->plan->resolution === '1080p')
                    <iframe id="video-player" src="{{ $movie->url_1080 }}" class="w-full h-full shadow-inner"
                        allowfullscreen allow="autoplay; encrypted-media; picture-in-picture">
                    </iframe>
                @elseif ($subscription->plan->resolution === '4k')
                    <iframe id="video-player" src="{{ $movie->url_4k }}" class="w-full h-full shadow-inner"
                        allowfullscreen allow="autoplay; encrypted-media; picture-in-picture">
                    </iframe>
                @else
                    <iframe id="video-player" src="{{ $movie->url_720 }}" class="w-full h-full shadow-inner"
                        allowfullscreen allow="autoplay; encrypted-media; picture-in-picture">
                    </iframe>
                @endif

            </div>
        </div>

        <!-- ─── 2. STREAM CONTROL & METADATA SECTION ─── -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Sisi Kiri: Informasi Film & Kontrol Resolusi -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- Judul & Badge Kualitas Aktif -->
                    <div class="border-b border-zinc-900 pb-4 space-y-2">
                        <div class="flex flex-wrap items-center gap-2 text-[10px] font-black tracking-widest uppercase">
                            <span
                                class="bg-red-600 text-white px-2 py-0.5 rounded-sm flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-circle text-[6px]"></i> Live Streaming
                            </span>
                            <span class="bg-zinc-900 border border-zinc-800 text-gray-400 px-2 py-0.5 rounded">
                                {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}m
                            </span>
                            <span class="bg-zinc-900 border border-zinc-800 text-gray-400 px-2 py-0.5 rounded">
                                {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-black text-white uppercase tracking-tight leading-tight">
                            {{ $movie->title }}
                        </h1>
                    </div>

                    <!-- Sinopsis Singkat -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Storyline</h4>
                        <p class="text-xs sm:text-sm text-gray-400 leading-relaxed max-w-4xl">
                            {{ $movie->description }}
                        </p>
                    </div>

                </div>

                <!-- Sisi Kanan: Panel Status Akses Premium & FORM RATING (FULL PHP) -->
                <div class="lg:col-span-4 space-y-4">

                    <!-- ─── FORM RATING WITH DECIMAL (FULL PHP) ─── -->
                    <div
                        class="bg-zinc-900/40 border border-zinc-900/80 p-5 rounded-xl space-y-4 shadow-xl backdrop-blur-sm">
                        <div class="flex items-center justify-between border-b border-zinc-800/80 pb-3">
                            <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-star text-yellow-500"></i> Rate Movie
                            </h3>

                            <!-- Menampilkan rating user saat ini (jika ada) -->

                            @if ($userRating)
                                <span
                                    class="text-[10px] bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-0.5 rounded font-bold">
                                    Your Rating: {{ number_format($userRating->rating, 1) }} ★
                                </span>
                            @endif
                        </div>

                        <!-- Form HTML Murni -->
                        <form action="{{ route('ratings.store', $movie) }}" method="POST" class="space-y-4">
                            @csrf

                            <div class="space-y-1.5">
                                <label for="rating"
                                    class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">
                                    Choose Rating Score:
                                </label>

                                <!-- Dropdown Pilihan Angka Koma (Kelipatan 0.5) -->
                                <div class="relative">
                                    <select name="rating" id="rating"
                                        class="w-full bg-zinc-900 border border-zinc-800 text-white text-xs font-bold rounded-lg p-3 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none cursor-pointer appearance-none pr-8">
                                        <option value="" disabled
                                            {{ old('rating', $userRating) ? '' : 'selected' }}>-- Select Rating Score
                                            --</option>

                                        <!-- Loop Kelipatan 0.5 dari 5.0 sampai 0.5 -->
                                        @for ($val = 5.0; $val >= 0.5; $val -= 0.5)
                                            <option value="{{ $val }}"
                                                {{ (string) old('rating', $userRating) === (string) $val ? 'selected' : '' }}>
                                                {{ number_format($val, 1) }} ★
                                                {{ $val >= 4.5 ? '(Excellent)' : ($val >= 3.5 ? '(Good)' : ($val >= 2.5 ? '(Average)' : '(Poor)')) }}
                                            </option>
                                        @endfor
                                    </select>

                                    <!-- Icon Panah Dropdown -->
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs py-2.5 px-4 rounded-lg border border-red-700/50 transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-paper-plane text-[10px]"></i>
                                <span>Submit Rating</span>
                            </button>
                        </form>
                    </div>


                    <!-- Panel Status Subscription Plan -->
                    <div
                        class="bg-zinc-900/40 border border-zinc-900/80 p-5 rounded-xl space-y-4 shadow-xl backdrop-blur-sm text-xs">
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center">
                                    <i class="fa-solid fa-crown mr-2 text-yellow-500"></i> Subscription Active
                                </h3>

                                @if ($subscription->plan->title === 'Premium' || $subscription->plan->title === 'Gold')
                                    <span
                                        class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-0.5 text-[9px] font-extrabold rounded uppercase">
                                        {{ $subscription->plan->title }}
                                    </span>
                                @else
                                    <span
                                        class="bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-0.5 text-[9px] font-extrabold rounded uppercase">
                                        {{ $subscription->plan->title }}
                                    </span>
                                @endif

                            </div>
                            <p class="text-[11px] text-gray-500">
                                Logged in as <span class="text-zinc-300 font-medium">{{ auth()->user()->name }}</span>.
                                You have full access to high-bitrate audio and crystal-clear streams.
                            </p>
                        </div>

                        <!-- Utility Action Buttons -->
                        <div class="pt-3 border-t border-zinc-800/80 space-y-2">
                            <button
                                class="w-full flex items-center justify-center space-x-2 bg-zinc-900 hover:bg-zinc-800 text-gray-300 font-bold p-2.5 rounded-lg border border-zinc-800 transition">
                                <i class="fa-solid fa-circle-info text-gray-400 text-[11px]"></i>
                                <span>Report buffering / broken stream</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
