<!doctype html>
<html lang="en" class="h-full text-gray-100 bg-zinc-950">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Codeflix - Watch Movies' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="h-full font-sans antialiased bg-zinc-950">
    <div class="flex flex-col min-h-screen">

        <nav
            class="sticky top-0 z-50 flex items-center justify-between px-4 py-4 transition-colors duration-300 border-b bg-gradient-to-b from-black/90 to-zinc-950/0 backdrop-blur-md border-zinc-900/40 sm:px-6 lg:px-12">
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold tracking-tighter text-red-650">
                    CODEFLIX
                </a>

                <div class="items-center hidden space-x-5 text-sm font-medium text-gray-300 md:flex">
                    <a href="{{ route('dashboard') }}" class="text-white transition hover:text-gray-300">Home</a>
                    {{-- <a href="#" class="transition hover:text-white">Series</a> --}}
                    <a href="{{ route('movies.index') }}" class="transition hover:text-white">Movies</a>
                    <a href="{{ route('crews.index') }}" class="transition hover:text-white">Casts & Crew</a>
                    <a href="#" class="transition hover:text-white">My List</a>
                    {{-- <a href="{{ route('subscriptions.index') }}" class="transition hover:text-white">Subscriptions</a> --}}
                </div>
            </div>

            <div class="flex items-center space-x-6 text-sm">
                <button class="transition hover:text-gray-400"><i
                        class="text-lg fa-solid fa-magnifying-glass"></i></button>
                <button class="relative transition hover:text-gray-400"><i
                        class="text-lg fa-solid fa-bell"></i></button>

                <div class="relative flex items-center space-x-2 cursor-pointer group">
                    <div
                        class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded shadow">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <i class="text-xs text-gray-400 transition fa-solid fa-caret-down group-hover:text-white"></i>

                    <div
                        class="absolute right-0 hidden w-48 py-2 transition duration-200 border rounded shadow-xl top-8 bg-zinc-900 border-zinc-800 group-hover:block">
                        <span class="block px-4 py-2 mb-1 text-xs text-gray-400 border-b border-zinc-800">Hi,
                            {{ auth()->user()->name ?? 'Member' }}</span>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-white transition hover:bg-zinc-800">Account Setting</a>

                        <a href="{{ route('subscriptions.index') }}"
                            class="block px-4 py-2 text-white transition hover:bg-zinc-800">Subscriptions</a>

                        @if (auth()->user()?->hasRole('admin'))
                            <a href="/admin" class="block px-4 py-2 text-red-400 transition hover:bg-zinc-800">Admin
                                Panel</a>
                        @endif

                        <hr class="my-1 border-zinc-800">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2 text-left text-gray-300 transition hover:bg-zinc-800 hover:text-white">
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
            class="px-4 py-8 mt-20 text-xs text-center text-gray-600 border-t bg-zinc-950 sm:px-12 border-zinc-900/60">
            <p class="mb-2">&copy; {{ date('Y') }} Codeflix Inc. All rights reserved.</p>
            <div class="flex justify-center space-x-4 text-gray-500">
                <a href="#" class="hover:underline">Audio Description</a>
                <a href="#" class="hover:underline">Help Center</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Terms of Use</a>
            </div>
        </footer>
    </div>
    <x-alert />
    {{ $scripts ?? '' }}
</body>

</html>
