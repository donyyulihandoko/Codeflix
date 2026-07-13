<x-app-layout>
    <x-slot:title>Discover Premium Movies - Codeflix</x-slot>

    <div class="relative w-full h-[55vh] sm:h-[65vh] bg-black overflow-hidden border-b border-zinc-900">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1925&auto=format&fit=crop"
                class="w-full h-full object-cover opacity-35 filter blur-[1px]" alt="Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-transparent to-transparent"></div>
        </div>
        <div class="absolute inset-0 flex flex-col justify-end px-4 sm:px-12 lg:px-20 pb-12 max-w-3xl space-y-4">
            <div class="flex items-center space-x-2 text-xs font-black tracking-widest text-red-500 uppercase">
                <i class="fa-solid fa-fire-flame-curved animate-pulse"></i><span>Now Trending</span>
            </div>
            <h1 class="text-3xl sm:text-6xl font-black text-white uppercase tracking-tight leading-none">Unlimited
                Entertainment.</h1>
            <p class="text-xs sm:text-sm text-gray-400 max-w-xl line-clamp-2">Experience high-bitrate crystal clear
                streams from our premium libraries.</p>

        </div>
    </div>

    <div class="px-4 sm:px-12 lg:px-20 pt-12 pb-24 bg-zinc-950">
        @livewire('movie-list')
    </div>
</x-app-layout>
