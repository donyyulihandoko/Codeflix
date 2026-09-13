<x-app-layout>
    <x-slot:title>Artis & Kru Sinematik - Codeflix</x-slot>

    <!-- MAIN CONTAINER DENGAN BACKGROUND MULTI-LAYER & RED GLOW -->
    <div class="relative min-h-screen bg-zinc-950 text-zinc-100 overflow-hidden">

        <!-- 1. Ambient Red Glow Effect (Efek Cahaya Merah Sinematik di Background) -->
        <div
            class="absolute -top-40 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-gradient-to-b from-red-600/20 via-red-900/10 to-transparent blur-[120px] pointer-events-none">
        </div>
        <div class="absolute top-1/3 -left-40 w-[500px] h-[500px] bg-red-900/10 blur-[150px] pointer-events-none"></div>

        <!-- 2. Pattern Overlay (Pola Bintik / Dot Grid Halus) -->
        <div
            class="absolute inset-0 bg-[radial-gradient(#27272a_1px,transparent_1px)] [background-size:24px_24px] opacity-40 pointer-events-none">
        </div>

        <!-- HERO BANNER SECTION -->
        <div class="relative w-full h-[45vh] sm:h-[52vh] flex items-end border-b border-zinc-800/60">
            <!-- Background Image dengan Vignette Radial -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover opacity-30 filter blur-[1px]" alt="Crews Hero">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/80 to-transparent"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 px-4 sm:px-12 lg:px-20 pb-12 max-w-4xl space-y-3">
                <div
                    class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-red-950/60 border border-red-800/40 text-xs font-black tracking-widest text-red-400 uppercase backdrop-blur-md">
                    <i class="fa-solid fa-users-gear animate-pulse"></i>
                    <span>Talent & Filmmakers</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight leading-none">
                    Mata di Balik <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-red-400 to-amber-300">Layar
                        & Panggung.</span>
                </h1>

                <p class="text-xs sm:text-sm text-zinc-400 max-w-xl leading-relaxed">
                    Jelajahi sutradara visioner, penulis naskah legendaris, dan aktor berprestasi yang menghidupkan
                    setiap mahakarya sinema di Codeflix.
                </p>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <div class="relative z-10 px-4 sm:px-12 lg:px-20 pt-10 pb-24">
            @livewire('crew-list')
        </div>

    </div>
</x-app-layout>
