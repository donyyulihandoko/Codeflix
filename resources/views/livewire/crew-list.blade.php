<div>
    <div class="space-y-8">

        <!-- Header Section + Live Search Bar -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-zinc-800/80 pb-6">
            <!-- Title & Badge -->
            <div class="flex items-center space-x-3.5">
                <div
                    class="p-3 bg-gradient-to-br from-red-600/20 to-red-950/40 border border-red-500/30 rounded-2xl text-red-500 shadow-lg shadow-red-950/40">
                    <i class="fa-solid fa-users-gear text-lg"></i>
                </div>
                <div>
                    <h2
                        class="text-xl sm:text-2xl font-extrabold text-white tracking-tight uppercase flex items-center gap-2">
                        <span>Sinematris & Kru</span>
                    </h2>
                    <p class="text-xs text-zinc-400 mt-0.5">
                        Jelajahi talenta hebat di balik film-film populer Codeflix.
                    </p>
                </div>
            </div>

            <!-- Search Input Box -->
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-zinc-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>

                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama sutradara, aktor, penulis..."
                    class="w-full bg-zinc-900/90 border border-zinc-800/90 text-zinc-100 placeholder-zinc-500 text-xs rounded-xl pl-9 pr-9 py-2.5 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 shadow-inner transition duration-200">

                <!-- Live Indicator Spinner -->
                <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fa-solid fa-spinner animate-spin text-red-500 text-xs"></i>
                </div>
            </div>
        </div>

        <!-- Grid Konten Artis / Kru -->
        @if ($crews->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                @foreach ($crews as $crew)
                    <a href="{{ route('crews.show', $crew) }}"
                        class="group relative bg-gradient-to-b from-zinc-900/80 via-zinc-900/40 to-zinc-950/90 rounded-2xl overflow-hidden border border-zinc-800/80 hover:border-red-600/50 hover:scale-[1.03] transition-all duration-300 shadow-lg hover:shadow-2xl hover:shadow-red-950/30 flex flex-col justify-between p-4 text-center backdrop-blur-md">

                        <!-- Ambient Top Glow on Hover -->
                        <div
                            class="absolute -top-12 left-1/2 -translate-x-1/2 w-24 h-24 bg-red-600/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
                        </div>

                        <!-- Foto Profile Container -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div
                                class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden bg-zinc-950 border-2 border-zinc-800/80 group-hover:border-red-600 transition-all duration-300 mb-3.5 shadow-xl relative flex-shrink-0 group-hover:rotate-1">
                                @if ($crew->photo)
                                    <img src="{{ Str::startsWith($crew->photo, 'http') ? $crew->photo : Storage::url($crew->photo) }}"
                                        alt="{{ $crew->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center text-zinc-700 bg-zinc-900/90">
                                        <i class="fa-solid fa-user text-3xl"></i>
                                    </div>
                                @endif

                                <!-- Glass Overlay di Foto saat Hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>

                            <!-- Detail Crew -->
                            <div class="w-full space-y-1">
                                <h3
                                    class="font-extrabold text-white text-xs sm:text-sm group-hover:text-red-500 transition-colors line-clamp-1 uppercase tracking-tight">
                                    {{ $crew->name }}
                                </h3>

                                @if ($crew->birth_date)
                                    <p
                                        class="text-[10px] text-zinc-400 font-medium flex items-center justify-center gap-1">
                                        <i class="fa-regular fa-calendar-days text-[9px] text-zinc-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($crew->birth_date)->translatedFormat('d M Y') }}</span>
                                    </p>
                                @else
                                    <p class="text-[10px] text-zinc-400 font-medium">&nbsp;</p>
                                @endif
                            </div>
                        </div>

                        <!-- Lower Section: Role Badges & Action Link -->
                        <div class="relative z-10 pt-3 mt-2 border-t border-zinc-800/60 w-full">
                            <!-- Role Badges -->
                            <div class="flex items-center justify-center gap-1.5 min-h-[22px]">
                                @if (($crew->directed_movies_count ?? 0) > 0)
                                    <span
                                        class="px-1.5 py-0.5 text-[9px] font-semibold rounded-md bg-red-950/80 text-red-400 border border-red-800/60 shadow-sm"
                                        title="Sutradara">
                                        <i class="fa-solid fa-clapperboard mr-0.5"></i> Dir
                                    </span>
                                @endif

                                @if (($crew->written_movies_count ?? 0) > 0)
                                    <span
                                        class="px-1.5 py-0.5 text-[9px] font-semibold rounded-md bg-amber-950/80 text-amber-400 border border-amber-800/60 shadow-sm"
                                        title="Penulis">
                                        <i class="fa-solid fa-pen-nib mr-0.5"></i> Writer
                                    </span>
                                @endif

                                @if (($crew->starred_movies_count ?? 0) > 0)
                                    <span
                                        class="px-1.5 py-0.5 text-[9px] font-semibold rounded-md bg-blue-950/80 text-blue-400 border border-blue-800/60 shadow-sm"
                                        title="Pemeran">
                                        <i class="fa-solid fa-star mr-0.5"></i> Cast
                                    </span>
                                @endif
                            </div>

                            <!-- Hover View Profile Hint -->
                            <div
                                class="mt-2.5 text-[10px] font-bold text-zinc-400 group-hover:text-red-400 transition-colors flex items-center justify-center gap-1">
                                <span>Lihat Profil</span>
                                <i
                                    class="fa-solid fa-arrow-right text-[8px] transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-12">
                {{ $crews->links('livewire::simple-tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div
                class="py-16 text-center bg-zinc-900/40 rounded-3xl border border-zinc-800/80 max-w-lg mx-auto my-8 backdrop-blur-sm">
                <div
                    class="w-16 h-16 bg-zinc-800/60 border border-zinc-700/50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-zinc-500 shadow-inner">
                    <i class="fa-solid fa-user-slash text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-white uppercase tracking-wider">Artis / Kru Tidak Ditemukan</h3>
                <p class="text-xs text-zinc-400 mt-1 max-w-xs mx-auto">
                    Tidak ada hasil yang cocok dengan pencarian kata kunci kamu saat ini.
                </p>

                @if (!empty($search))
                    <button wire:click="$set('search', '')"
                        class="mt-5 px-4 py-2 bg-red-600 hover:bg-red-700 text-xs font-bold text-white rounded-xl transition shadow-md shadow-red-950/50">
                        Reset Pencarian
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
