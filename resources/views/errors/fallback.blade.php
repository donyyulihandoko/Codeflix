<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Terpotong! | Codeflix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-950 text-gray-100 min-h-screen flex items-center justify-center overflow-hidden relative font-sans">

    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-red-800/10 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="container mx-auto px-6 text-center relative z-10">

        <div class="flex justify-center mb-6">
            <div class="relative">
                <svg class="w-24 h-24 text-red-500 animate-pulse" fill="none" stroke="currentColor"
                    stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 20.25h12m-12-3h12m-12-3h12m-12-3h12m-12-3h12m-12-3h12m-12-3h12M12 3.75v16.5M3 12h18">
                    </path>
                </svg>
                <span
                    class="absolute -bottom-2 -right-4 bg-red-600 text-white text-xs font-black px-2.5 py-1 rounded-full uppercase tracking-wider shadow-lg shadow-red-600/50">
                    404 Error
                </span>
            </div>
        </div>

        <h1
            class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-gray-500 tracking-tight mb-4">
            CUT! ADEGAN HILANG
        </h1>

        <p class="text-gray-400 text-base md:text-lg max-w-lg mx-auto leading-relaxed mb-10">
            Waduh! Sutradara kami sepertinya lupa menaruh roll film untuk halaman ini. Halaman yang kamu cari tidak
            ditemukan atau sudah dihapus dari daftar putar.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ Auth::user()->isAdmin() ? route('filament.admin.pages.dashboard') : route('dashboard') }}"
                class="w-full sm:w-auto px-8 py-3.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 hover:shadow-red-600/50 transition duration-300 transform hover:-translate-y-0.5 ease-in-out text-center">
                Kembali ke Beranda
            </a>

            <button onclick="window.history.back()"
                class="w-full sm:w-auto px-8 py-3.5 bg-gray-900/80 hover:bg-gray-800 border border-gray-800 hover:border-gray-700 text-gray-300 hover:text-white font-semibold rounded-xl transition duration-300 text-center">
                Kembali ke Halaman Sebelumnya
            </button>
        </div>

        <div class="mt-16 text-xs text-gray-600 tracking-widest uppercase">
            &copy; {{ date('Y') }} Codeflix Inc. All rights reserved.
        </div>
    </div>

</body>

</html>
