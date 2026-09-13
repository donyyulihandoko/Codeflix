<x-app-layout>
    <x-slot:title>My Watchlist - Codeflix</x-slot:title>

    <!-- Hero Banner Section -->
    <div class="relative w-full h-[40vh] sm:h-[50vh] bg-black overflow-hidden border-b border-zinc-900">
        <div class="absolute inset-0">
            <!-- Hero Background (Sinematik Projector & Cinema Vibe) -->
            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=2070&auto=format&fit=crop"
                class="w-full h-full object-cover opacity-25 filter blur-[1px] scale-105" alt="Cinema Hall Background">

            <!-- Vignette & Gradient Overlays -->
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/40 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="absolute inset-0 flex flex-col justify-end px-4 sm:px-12 lg:px-20 pb-10 max-w-4xl space-y-3">
            <div class="flex items-center space-x-2 text-xs font-black tracking-widest text-red-500 uppercase">
                <i class="fa-solid fa-film"></i>
                <span>Personal Cinema Vault</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight leading-none drop-shadow-md">
                Your Private Reel.
            </h1>

            <p class="text-xs sm:text-sm text-gray-400 max-w-xl line-clamp-2 leading-relaxed">
                Ruang sinematik pribadimu. Semua tontonan pilihan yang sudah kamu simpan dan menanti untuk diputar kapan
                pun kamu siap.
            </p>
        </div>
    </div>

    <!-- Content Grid Section -->
    <div class="px-4 sm:px-12 lg:px-20 pt-10 pb-24 bg-zinc-950">

        @livewire('my-list-movies')

    </div>
</x-app-layout>
