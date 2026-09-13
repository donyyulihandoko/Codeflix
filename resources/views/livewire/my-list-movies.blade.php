<div>
    <div>
        <div class="space-y-6">

            <!-- Header Section + Live Search -->
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-900 pb-4">

                <!-- Left: Title & Icon Badge -->
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 bg-red-600/10 border border-red-500/20 rounded-xl text-red-500">
                        <i class="fa-solid fa-bookmark text-base sm:text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-wide uppercase">
                            My Watchlist
                        </h2>
                        <p class="text-xs text-gray-400 hidden sm:block">
                            Daftar film favorit yang tersimpan di akun kamu
                        </p>
                    </div>
                </div>

                <!-- Right: Search Input Box -->
                <div class="relative w-full sm:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                    </span>

                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari film di daftarmu..."
                        class="w-full bg-zinc-900/80 border border-zinc-800 text-gray-200 placeholder-gray-500 text-xs rounded-xl pl-9 pr-8 py-2.5 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200">

                    <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fa-solid fa-spinner animate-spin text-red-500 text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Movie Grid List -->
            @if ($myLists && $myLists->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-6 pt-2">
                    @foreach ($myLists as $item)
                        @if ($item->movie)
                            <div
                                class="group relative rounded-xl overflow-hidden bg-zinc-900 shadow-md aspect-[2/3] transition duration-300 hover:scale-105 hover:z-30 border border-zinc-900 hover:border-zinc-700">

                                <!-- Poster Film -->
                                <img src="{{ Str::startsWith($item->movie->poster, ['http://', 'https://']) ? $item->movie->poster : Storage::url($item->movie->poster) }}"
                                    alt="{{ $item->movie->title }} Poster" class="w-full h-full object-cover">

                                <!-- Tombol Hapus dari List (Top Left) -->
                                <div class="absolute top-2 left-2 z-40">

                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('mylists.destroy', $item) }}" method="POST">
                                        @method('DELETE')
                                        @csrf

                                        <button type="button"
                                            onclick="confirmDelete('delete-form-{{ $item->id }}', '{{ $item->movie->title ?? 'Film ini' }}')"
                                            class="w-7 h-7 rounded-full bg-black/70 hover:bg-red-600 text-zinc-300 hover:text-white backdrop-blur-md border border-white/10 flex items-center justify-center transition-all duration-200 shadow-md group/btn">
                                            <i
                                                class="fa-solid fa-xmark text-xs group-hover/btn:scale-110 transition-transform"></i>
                                        </button>
                                    </form>

                                </div>

                                <!-- Link & Overlay Hover -->
                                <a href="{{ route('movies.show', $item->movie) }}" class="absolute inset-0 z-10 block">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-black/40 p-3 flex flex-col justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-200">

                                        <!-- Top: Rating Badge -->
                                        <div class="flex justify-end">
                                            <div
                                                class="flex items-center gap-1 bg-black/70 backdrop-blur-md border border-yellow-500/30 text-yellow-400 text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                                                <i class="fa-solid fa-star text-[9px]"></i>
                                                <span>{{ $item->movie->ratings_avg_rating ? number_format($item->movie->ratings_avg_rating, 1) : 'N/A' }}</span>
                                            </div>
                                        </div>

                                        <!-- Bottom: Judul & Informasi -->
                                        <div>
                                            <p class="font-bold text-white text-xs truncate drop-shadow">
                                                {{ $item->movie->title }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] text-gray-300">
                                                <span>{{ $item->movie->release_date ? \Carbon\Carbon::parse($item->movie->release_date)->format('Y') : '-' }}</span>
                                                @if ($item->movie->duration)
                                                    <span>• {{ $item->movie->duration }} mnt</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </a>

                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                <div
                    class="mt-8 text-zinc-400 [&_button]:bg-zinc-900 [&_button]:border [&_button]:border-zinc-800 [&_button]:rounded-lg [&_button]:px-4 [&_button]:py-2 [&_button:hover]:bg-zinc-800 [&_button:hover]:text-white">
                    {{ $myLists->links('livewire::simple-tailwind') }}
                </div>
            @else
                <!-- Empty State -->
                <div
                    class="flex flex-col items-center justify-center text-center py-16 bg-zinc-900/20 border border-dashed border-zinc-800/80 rounded-2xl max-w-md mx-auto space-y-4 my-6">
                    <div
                        class="w-14 h-14 bg-zinc-900/80 rounded-2xl border border-zinc-800 text-zinc-500 flex items-center justify-center">
                        <i class="fa-solid fa-bookmark text-xl"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-white">Daftar Tontonan Kosong</h3>
                        <p class="text-xs text-gray-500 max-w-xs mx-auto">
                            @if ($search)
                                Tidak ada film di daftarmu yang cocok dengan kata kunci "{{ $search }}".
                            @else
                                Kamu belum menyimpan film apapun. Jelajahi katalog dan tambahkan film favoritmu.
                            @endif
                        </p>
                    </div>
                    @if (!$search)
                        <a href="{{ route('movies.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-xs font-bold text-white rounded-xl transition-all shadow-lg shadow-red-950/50">
                            <i class="fa-solid fa-compass text-xs"></i>
                            <span>Jelajahi Film</span>
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>
