<x-app-layout>
    <x-slot:title>Home - Codeflix Streaming</x-slot>

    <div class="relative w-full h-[55vh] sm:h-[75vh] bg-cover bg-center flex items-center px-4 sm:px-12 lg:px-20 before:absolute before:inset-0 before:bg-gradient-to-t before:from-zinc-950 before:via-zinc-950/30 before:to-black/40"
        style="background-image: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1920');">

        <div class="relative z-10 max-w-xl space-y-4">
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-red-600 text-white uppercase tracking-wider">
                <i class="fa-solid fa-fire mr-1"></i> Trending No. 1
            </span>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white drop-shadow-md">
                THE CODE MATRIX
            </h1>
            <p class="text-sm sm:text-base text-gray-300 drop-shadow">
                Seorang software engineer muda menemukan bahwa dunia nyata yang ia tinggali hanyalah sebuah simulasi
                baris kode pemrograman raksasa yang dikendalikan oleh kecerdasan buatan.
            </p>

            <div class="flex items-center space-x-3 pt-2">
                <a href="#"
                    class="flex items-center space-x-2 bg-white hover:bg-gray-200 text-black font-bold px-6 py-2.5 rounded shadow transition duration-200">
                    <i class="fa-solid fa-play text-lg"></i>
                    <span>Play Now</span>
                </a>
                <button
                    class="flex items-center space-x-2 bg-zinc-600/60 hover:bg-zinc-600/80 text-white font-semibold px-5 py-2.5 rounded shadow backdrop-blur-sm transition duration-200">
                    <i class="fa-solid fa-circle-info text-lg"></i>
                    <span>More Info</span>
                </button>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-12 lg:px-20 space-y-10 -mt-10 sm:-mt-20 relative z-20">

        <div class="space-y-3">
            <h2
                class="text-xl font-bold text-white tracking-wide hover:text-red-500 cursor-pointer transition inline-flex items-center group">
                Continue Watching
                <i
                    class="fa-solid fa-chevron-right text-xs ml-2 opacity-0 group-hover:opacity-100 transition duration-200"></i>
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @for ($i = 1; $i <= 6; $i++)
                    <div
                        class="group relative rounded-md overflow-hidden bg-zinc-900 cursor-pointer shadow aspect-[16/9] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">
                        <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=600"
                            alt="Movie Thumbnail" class="w-full h-full object-cover">

                        <div
                            class="absolute inset-0 bg-black/80 p-3 opacity-0 group-hover:opacity-100 flex flex-col justify-between transition-opacity duration-200 text-xs">
                            <div class="font-bold text-white truncate">Movie Title Sample {{ $i }}</div>
                            <div class="flex items-center space-x-2 text-green-400 font-semibold">
                                <span>98% Match</span>
                                <span class="border border-gray-600 px-1 text-[10px] text-gray-300 rounded">13+</span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="space-y-3">
            <h2
                class="text-xl font-bold text-white tracking-wide hover:text-red-500 cursor-pointer transition inline-flex items-center group">
                Action & Sci-Fi Hollywood
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @for ($i = 1; $i <= 6; $i++)
                    <div
                        class="group relative rounded-md overflow-hidden bg-zinc-900 cursor-pointer shadow aspect-[16/9] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">
                        <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=600"
                            alt="Movie Thumbnail" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-black/80 p-3 opacity-0 group-hover:opacity-100 flex flex-col justify-between transition-opacity duration-200 text-xs">
                            <div class="font-bold text-white truncate">Action Thriller {{ $i }}</div>
                            <div class="flex items-center space-x-2 text-green-400 font-semibold">
                                <span>95% Match</span>
                                <span class="border border-gray-600 px-1 text-[10px] text-gray-300 rounded">16+</span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    </div>
</x-app-layout>
