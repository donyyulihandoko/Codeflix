<!doctype html>
<html lang="en" class="h-full bg-zinc-950 text-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Codeflix - Watch Movies' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="h-full font-sans antialiased bg-zinc-950">
    <div class="min-h-screen flex flex-col">

        <nav
            class="sticky top-0 z-50 bg-gradient-to-b from-black/90 to-zinc-950/0 backdrop-blur-md border-b border-zinc-900/40 px-4 py-4 sm:px-6 lg:px-12 flex items-center justify-between transition-colors duration-300">
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold tracking-tighter text-red-650">
                    CODEFLIX
                </a>

                <div class="hidden md:flex items-center space-x-5 text-sm font-medium text-gray-300">
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-300 transition">Home</a>
                    {{-- <a href="#" class="hover:text-white transition">Series</a> --}}
                    <a href="{{ route('movies.index') }}" class="hover:text-white transition">Movies</a>
                    <a href="#" class="hover:text-white transition">New & Popular</a>
                    <a href="#" class="hover:text-white transition">My List</a>
                </div>
            </div>

            <div class="flex items-center space-x-6 text-sm">
                <button class="hover:text-gray-400 transition"><i
                        class="fa-solid fa-magnifying-glass text-lg"></i></button>
                <button class="relative hover:text-gray-400 transition"><i
                        class="fa-solid fa-bell text-lg"></i></button>

                <div class="relative flex items-center space-x-2 group cursor-pointer">
                    <div
                        class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center text-white font-bold text-sm shadow">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <i class="fa-solid fa-caret-down text-xs text-gray-400 group-hover:text-white transition"></i>

                    <div
                        class="absolute right-0 top-8 w-48 bg-zinc-900 border border-zinc-800 rounded shadow-xl py-2 hidden group-hover:block transition duration-200">
                        <span class="block px-4 py-2 text-xs text-gray-400 border-b border-zinc-800 mb-1">Hi,
                            {{ auth()->user()->name ?? 'Member' }}</span>
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 hover:bg-zinc-800 text-white transition">Account Dashboard</a>

                        @if (auth()->user()?->hasRole('admin'))
                            <a href="/admin" class="block px-4 py-2 hover:bg-zinc-800 text-red-400 transition">Admin
                                Panel</a>
                        @endif

                        <hr class="border-zinc-800 my-1">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-zinc-800 text-gray-300 hover:text-white transition">
                                Sign Out of Codeflix
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer
            class="bg-zinc-950 py-8 px-4 sm:px-12 text-center text-xs text-gray-600 border-t border-zinc-900/60 mt-20">
            <p class="mb-2">&copy; {{ date('Y') }} Codeflix Inc. All rights reserved.</p>
            <div class="flex justify-center space-x-4 text-gray-500">
                <a href="#" class="hover:underline">Audio Description</a>
                <a href="#" class="hover:underline">Help Center</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Terms of Use</a>
            </div>
        </footer>
    </div>

    {{ $scripts ?? '' }}
</body>

</html>
