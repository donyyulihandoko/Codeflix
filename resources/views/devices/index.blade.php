<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-900 dark:text-white tracking-tight">
                {{ __('Keamanan & Perangkat') }}
            </h2>
            <p class="text-sm font-medium text-slate-600 dark:text-slate-300 mt-1">
                Kelola sesi login dan perangkat terhubung pada akun Anda.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Banner Status Kuota Perangkat --}}
            <div
                class="relative overflow-hidden p-6 sm:p-8 bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950 text-white rounded-3xl shadow-2xl border border-indigo-500/30">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/20 text-indigo-100 border border-indigo-400/30 shadow-xs">
                            <span
                                class="w-2.5 h-2.5 rounded-full {{ $devices->count() >= $maxDevice ? 'bg-amber-400' : 'bg-emerald-400' }} animate-pulse"></span>
                            Batas Sesi Perangkat
                        </div>
                        <h3 class="text-3xl font-black tracking-tight text-white">
                            {{ $devices->count() }} <span class="text-indigo-200 font-semibold text-xl">/
                                {{ $maxDevice }}
                                Perangkat Aktif</span>
                        </h3>
                        <p class="text-sm font-medium text-indigo-100 max-w-xl leading-relaxed">
                            Jika Anda mencapai batas maksimum, keluarkan salah satu perangkat di bawah ini untuk dapat
                            masuk dari perangkat baru.
                        </p>
                    </div>

                    {{-- Progress Bar Widget --}}
                    @php $usagePercent = min(100, round(($devices->count() / $maxDevice) * 100)); @endphp
                    <div
                        class="w-full md:w-60 bg-slate-900/80 backdrop-blur-xl p-4 rounded-2xl border border-indigo-400/30 shadow-lg">
                        <div class="flex justify-between text-xs font-bold text-white mb-2">
                            <span>Penggunaan Kapasitas</span>
                            <span class="text-indigo-300 font-extrabold">{{ $usagePercent }}%</span>
                        </div>
                        <div class="w-full bg-slate-950 rounded-full h-3 p-0.5 border border-white/10">
                            <div class="bg-gradient-to-r from-indigo-500 via-sky-400 to-emerald-400 h-2 rounded-full transition-all duration-700 shadow-sm"
                                style="width: {{ $usagePercent }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Soft Background Decorative Ambient --}}
                <div
                    class="absolute -right-12 -bottom-12 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute -left-12 -top-12 w-64 h-64 bg-sky-600/20 rounded-full blur-3xl pointer-events-none">
                </div>
            </div>

            {{-- Grid / List Perangkat --}}
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2 px-1">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Daftar Perangkat Terhubung
                </h3>

                <div class="grid grid-cols-1 gap-4">
                    @forelse ($devices as $device)
                        @php
                            $isCurrentDevice =
                                session('device_id') === $device->device_id ||
                                request()->cookie('device_id') === $device->device_id;

                            $platformLower = strtolower($device->platform ?? '');
                            $isMobile =
                                str_contains($platformLower, 'android') ||
                                str_contains($platformLower, 'ios') ||
                                str_contains($platformLower, 'iphone');
                        @endphp

                        {{-- Kartu Perangkat dengan Kontras Tinggi --}}
                        <div
                            class="group relative rounded-2xl p-5 transition-all duration-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4
                            {{ $isCurrentDevice
                                ? 'bg-indigo-50/90 dark:bg-slate-900/90 border-2 border-indigo-600 dark:border-indigo-500 shadow-md shadow-indigo-500/10'
                                : 'bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-slate-500 shadow-xs hover:shadow-md' }}">

                            <div class="flex items-start sm:items-center gap-4">
                                {{-- Visual Icon Badge --}}
                                <div
                                    class="p-3.5 rounded-2xl shrink-0 transition-transform duration-200 group-hover:scale-105 shadow-xs
                                    {{ $isCurrentDevice
                                        ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30'
                                        : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-600' }}">
                                    @if ($isMobile)
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>

                                {{-- Informasi Detail Perangkat --}}
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <h4 class="text-base font-extrabold text-slate-900 dark:text-white">
                                            {{ $device->device_name ?? 'Perangkat Tidak Dikenal' }}
                                        </h4>

                                        @if ($isCurrentDevice)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-500/40 shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Perangkat Ini
                                            </span>
                                        @endif
                                    </div>

                                    <div
                                        class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                                        <span>OS: <strong
                                                class="text-slate-900 dark:text-white font-bold">{{ $device->platform ?? 'Unknown' }}
                                                {{ $device->platform_version }}</strong></span>
                                        <span class="text-slate-400">•</span>
                                        <span>Browser: <strong
                                                class="text-slate-900 dark:text-white font-bold">{{ $device->browser ?? 'Unknown' }}
                                                {{ $device->browser_version }}</strong></span>
                                    </div>

                                    <div
                                        class="text-xs font-medium text-slate-600 dark:text-slate-300 flex items-center gap-1.5 pt-0.5">
                                        <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Terakhir Aktif:
                                        <strong
                                            class="text-slate-800 dark:text-slate-200 font-semibold">{{ $device->last_active ? $device->last_active->diffForHumans() : 'Baru Saja' }}</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Aksi Hapus/Revoke Perangkat --}}
                            <div
                                class="pt-3 sm:pt-0 border-t sm:border-0 border-slate-200 dark:border-slate-700 flex justify-end items-center">
                                @if (!$isCurrentDevice)
                                    <form id="delete-form-{{ $device->id }}"
                                        action="{{ route('devices.destroy', $device) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete('delete-form-{{ $device->id }}', '{{ $device->device_name ?? 'Device ini' }}')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-rose-700 hover:text-white dark:text-rose-300 bg-rose-100 hover:bg-rose-600 dark:bg-rose-950/60 dark:hover:bg-rose-600 rounded-xl transition-all duration-150 border border-rose-300 dark:border-rose-800 active:scale-95 shadow-2xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Keluarkan
                                        </button>
                                    </form>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-950 border border-indigo-300 dark:border-indigo-800 px-3.5 py-1.5 rounded-xl cursor-default select-none shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Sesi Aktif
                                    </span>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div
                            class="bg-white dark:bg-slate-800 rounded-3xl p-8 text-center border border-slate-200 dark:border-slate-700 shadow-xs">
                            <div
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-slate-700 dark:text-slate-200 font-bold">Belum ada perangkat terdaftar.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
