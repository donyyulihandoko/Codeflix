<x-app-layout>
    <x-slot:title>{{ $category->title }} Movies - Codeflix</x-slot:title>

    <!-- Hero Banner Section (Gambar Sinematik HD Statis) -->
    <div class="relative w-full h-[45vh] sm:h-[55vh] bg-zinc-950 overflow-hidden border-b border-zinc-900/80">

        <!-- Hero Background Image -->
        <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=2070&auto=format&fit=crop"
            class="absolute inset-0 w-full h-full object-cover opacity-35 filter blur-[1px] scale-105 transition-transform duration-1000 hover:scale-100 select-none pointer-events-none"
            alt="{{ $category->title }} Background">

        <!-- Vignette & Gradient Overlays (Membuat Teks Tetap Sangat Jelas Readability-nya) -->
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/70 to-zinc-950/30"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/60 to-transparent"></div>

        <!-- Red Subtle Accent Ambient Glow -->
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Tombol Back & Meta Top Navigation -->
        <div class="absolute top-6 px-4 sm:px-12 lg:px-20 z-10 w-full flex items-center justify-between">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center space-x-2 text-xs font-semibold text-zinc-300 hover:text-white bg-black/60 hover:bg-black/90 px-4 py-2 rounded-full backdrop-blur-md border border-white/10 transition-all shadow-lg">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>

            <div
                class="hidden sm:flex items-center space-x-2 bg-red-500/10 border border-red-500/20 px-3 py-1 rounded-full text-[11px] font-bold text-red-400 tracking-wider uppercase backdrop-blur-md">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                <span>Category Explorer</span>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="absolute inset-0 flex flex-col justify-end px-4 sm:px-12 lg:px-20 pb-12 max-w-4xl space-y-3 z-10">
            <div class="flex items-center space-x-3">
                <span
                    class="px-3 py-1 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest rounded-md shadow-lg shadow-red-950/50 border border-red-500/30">
                    Genre
                </span>
                <span
                    class="text-xs font-semibold text-zinc-300 flex items-center gap-1.5 bg-black/40 px-3 py-1 rounded-md border border-white/5 backdrop-blur-sm">
                    <i class="fa-solid fa-clapperboard text-red-500"></i>
                    {{ $category->movies_count ?? $category->movies->count() }} Film Tersedia
                </span>
            </div>

            <h1 class="text-4xl sm:text-6xl font-black text-white uppercase tracking-tight leading-none drop-shadow-lg">
                {{ $category->title }}.
            </h1>

            <p class="text-xs sm:text-sm text-zinc-300 max-w-2xl line-clamp-2 leading-relaxed drop-shadow">
                {{ $category->description ?? 'Jelajahi koleksi film terbaik dalam kategori ' . $category->title . '. Ditemani alur cerita mendalam, aksi memukau, dan pengalaman sinematik tak terlupakan.' }}
            </p>
        </div>
    </div>

    <!-- Content Grid Section -->
    <div class="px-4 sm:px-12 lg:px-20 pt-10 pb-24 bg-zinc-950">
        @livewire('category-movie', ['category' => $category], key($category->id))
    </div>
</x-app-layout>
