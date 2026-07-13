<x-app-layout>
    <x-slot:title>Watching {{ $movie->title }} - Codeflix Premium</x-slot>

    <div class="w-full min-h-screen bg-zinc-950 pb-24 text-gray-200">

        <!-- ─── 1. CINEMATIC THEATER VIDEO PLAYER CONTAINER ─── -->
        <div class="w-full bg-black border-b border-zinc-900 shadow-2xl relative">
            <div class="max-w-6xl mx-auto aspect-video relative group">

                <!-- Floating Back Button (Muncul elegan di pojok kiri atas player) -->
                <div
                    class="absolute top-4 left-4 z-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="{{ route('movies.show', $movie) }}"
                        class="flex items-center space-x-2 bg-zinc-950/80 hover:bg-zinc-900 border border-zinc-800 text-gray-300 hover:text-white px-3 py-2 rounded-lg text-xs font-bold backdrop-blur-md transition shadow-lg">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Back to Details</span>
                    </a>
                </div>

                <!-- Iframe Video Player Utama -->
                <iframe id="video-player" src="{{ $movie->url_1080 }}" class="w-full h-full shadow-inner" allowfullscreen
                    allow="autoplay; encrypted-media; picture-in-picture">
                </iframe>
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

                    <!-- Pilihan Server / Resolusi Kualitas (Interaktif JavaScript) -->
                    <div class="bg-zinc-900/20 border border-zinc-900/60 p-4 rounded-xl space-y-3">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-red-500"></i> Adjust Stream Quality
                        </h3>

                        <div class="flex flex-wrap gap-2 pt-1">
                            <!-- Tombol 1080p (Default Aktif) -->
                            <button onclick="switchQuality('{{ $movie->url_1080 }}', this)"
                                class="quality-btn flex items-center space-x-2 bg-red-600 text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-red-700/50 transition">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                <span>Full HD (1080p)</span>
                            </button>

                            <!-- Tombol 720p (Jika ada di database) -->
                            @if ($movie->url_720)
                                <button onclick="switchQuality('{{ $movie->url_720 }}', this)"
                                    class="quality-btn flex items-center space-x-2 bg-zinc-900 hover:bg-zinc-800 text-gray-400 hover:text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-zinc-800 transition">
                                    <i class="fa-solid fa-circle text-[10px] text-zinc-700"></i>
                                    <span>HD (720p)</span>
                                </button>
                            @endif

                            <!-- Tombol 4K (Jika ada di database) -->
                            @if ($movie->url_4k)
                                <button onclick="switchQuality('{{ $movie->url_4k }}', this)"
                                    class="quality-btn flex items-center space-x-2 bg-zinc-900 hover:bg-zinc-800 text-gray-400 hover:text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-zinc-800 transition">
                                    <i class="fa-solid fa-bolt text-yellow-500 text-[10px]"></i>
                                    <span>4K Ultra HD</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Sinopsis Singkat Pengingat Cerita -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Storyline</h4>
                        <p class="text-xs sm:text-sm text-gray-400 leading-relaxed max-w-4xl">
                            {{ $movie->description }}
                        </p>
                    </div>

                </div>

                <!-- Sisi Kanan: Panel Status Akses Premium -->
                <div class="lg:col-span-4 space-y-4">
                    <div
                        class="bg-zinc-900/40 border border-zinc-900/80 p-5 rounded-xl space-y-4 shadow-xl backdrop-blur-sm text-xs">
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center">
                                    <i class="fa-solid fa-crown mr-2 text-yellow-500"></i> Subscription Active
                                </h3>
                                <span
                                    class="bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-0.5 text-[9px] font-extrabold rounded uppercase">
                                    Premium
                                </span>
                            </div>
                            <p class="text-[11px] text-gray-500">Logged in as <span
                                    class="text-zinc-300 font-medium">{{ auth()->user()->name }}</span>. You have full
                                access to high-bitrate audio and crystal-clear streams.</p>
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

    <!-- ─── 3. JAVASCRIPT UTILITY (KONTROL RESOLUSI INSTAN) ─── -->
    <script>
        function switchQuality(videoUrl, buttonElement) {
            // 1. Ganti src iframe video player secara instan
            document.getElementById('video-player').src = videoUrl;

            // 2. Reset semua gaya tombol ke mode normal (tidak aktif)
            document.querySelectorAll('.quality-btn').forEach(btn => {
                btn.className =
                    "quality-btn flex items-center space-x-2 bg-zinc-900 hover:bg-zinc-800 text-gray-400 hover:text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-zinc-800 transition";
                // Reset icon di dalamnya menjadi dot abu-abu biasa
                const icon = btn.querySelector('i');
                if (icon && !icon.classList.contains('fa-bolt')) {
                    icon.className = "fa-solid fa-circle text-[10px] text-zinc-700";
                }
            });

            // 3. Ubah tombol yang diklik menjadi mode aktif (Merah Neon)
            buttonElement.className =
                "quality-btn flex items-center space-x-2 bg-red-600 text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-red-700/50 transition";

            // Ubah icon tombol aktif menjadi centang sukses
            const activeIcon = buttonElement.querySelector('i');
            if (activeIcon && !activeIcon.classList.contains('fa-bolt')) {
                activeIcon.className = "fa-solid fa-circle-check text-[10px]";
            }
        }
    </script>
</x-app-layout>
