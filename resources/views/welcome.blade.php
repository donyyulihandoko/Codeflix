<!doctype html>
<html lang="en" class="h-full bg-zinc-950 text-gray-150">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codeflix - Watch Movies Online</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-zinc-950 antialiased font-sans selection:bg-red-600 selection:text-white">

    <header
        class="relative w-full min-h-[85vh] sm:min-h-screen bg-cover bg-center flex flex-col justify-between before:absolute before:inset-0 before:bg-black/60 before:bg-gradient-to-t before:from-zinc-950 before:via-black/40 before:to-black/70"
        style="background-image: url('https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=1920');">

        <nav class="relative z-15 flex items-center justify-between px-6 py-6 md:px-16">
            <a href="/" class="text-3xl font-extrabold tracking-tighter text-red-650 sm:text-4xl">
                CODEFLIX
            </a>

            <div class="z-10">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded transition duration-200 shadow shadow-red-900/30">
                        Dashboard <i class="fa-solid fa-arrow-right ml-1.5 text-xs"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded transition duration-200 shadow shadow-red-900/30">
                        Sign In
                    </a>
                @endauth
            </div>
        </nav>

        <div
            class="relative z-10 flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto my-auto space-y-6">
            <h1
                class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight max-w-3xl drop-shadow-md">
                Unlimited movies, TV shows, and more
            </h1>
            <p class="text-lg sm:text-2xl text-gray-200 font-medium">
                Starts at IDR 50,000. Cancel anytime.
            </p>

            <div class="w-full pt-4 max-w-2xl">
                @auth
                    <div class="space-y-4">
                        <p class="text-gray-300 text-sm sm:text-base">Welcome back, <span
                                class="text-white font-bold">{{ auth()->user()->name }}</span>! Ready to watch your favorite
                            stream?</p>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-bold text-lg px-8 py-4 rounded transition duration-200 shadow-lg shadow-red-950/50">
                            <span>Start Watching Now</span>
                            <i class="fa-solid fa-circle-play text-xl"></i>
                        </a>
                    </div>
                @else
                    <form action="{{ route('register') }}" method="GET" class="space-y-4">
                        <p class="text-gray-300 text-sm sm:text-base">Ready to watch? Enter your registration form to create
                            your membership.</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-xl mx-auto">
                            <button type="submit"
                                class="w-full sm:w-auto flex items-center justify-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-bold text-lg px-8 py-3.5 rounded transition duration-200 whitespace-nowrap shadow-md">
                                <span>Get Started</span>
                                <i class="fa-solid fa-chevron-right text-sm"></i>
                            </button>
                        </div>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <section class="border-t-8 border-zinc-800 bg-black px-6 py-16 md:px-16 lg:px-24">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-zinc-900/50 border border-zinc-800 p-6 rounded-xl text-center space-y-3">
                <i class="fa-solid fa-tv text-3xl text-red-500"></i>
                <h3 class="text-xl font-bold text-white">Watch on your TV</h3>
                <p class="text-sm text-gray-400">Watch on Smart TVs, Playstation, Xbox, Chromecast, Apple TV, and more.
                </p>
            </div>
            <div class="bg-zinc-900/50 border border-zinc-800 p-6 rounded-xl text-center space-y-3">
                <i class="fa-solid fa-download text-3xl text-red-500"></i>
                <h3 class="text-xl font-bold text-white">Download & Watch</h3>
                <p class="text-sm text-gray-400">Save your favorites easily and always have something to watch offline.
                </p>
            </div>
            <div class="bg-zinc-900/50 border border-zinc-800 p-6 rounded-xl text-center space-y-3">
                <i class="fa-solid fa-layer-group text-3xl text-red-500"></i>
                <h3 class="text-xl font-bold text-white">Premium Package</h3>
                <p class="text-sm text-gray-400">Subscribe once and unlock high-quality 4K videos without ads interrupt.
                </p>
            </div>
        </div>
    </section>

    <section class="border-t-8 border-zinc-800 bg-black px-6 py-20 md:px-16">
        <div class="max-w-3xl mx-auto space-y-4">
            <h2 class="text-3xl font-extrabold text-white text-center mb-8 sm:text-4xl">Frequently Asked Questions</h2>

            <div
                class="bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 transition rounded-lg p-5 cursor-pointer group">
                <div class="flex items-center justify-between text-lg font-semibold text-white">
                    <span>What is Codeflix?</span>
                    <i class="fa-solid fa-plus transition group-hover:rotate-45"></i>
                </div>
            </div>

            <div
                class="bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 transition rounded-lg p-5 cursor-pointer group">
                <div class="flex items-center justify-between text-lg font-semibold text-white">
                    <span>How much does Codeflix cost?</span>
                    <i class="fa-solid fa-plus transition group-hover:rotate-45"></i>
                </div>
            </div>

            <div
                class="bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 transition rounded-lg p-5 cursor-pointer group">
                <div class="flex items-center justify-between text-lg font-semibold text-white">
                    <span>Where can I watch?</span>
                    <i class="fa-solid fa-plus transition group-hover:rotate-45"></i>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-900 bg-black py-10 px-6 text-center text-xs text-gray-500">
        <p class="mb-3">&copy; {{ date('Y') }} Codeflix Inc. All rights reserved.</p>
        <div class="flex justify-center space-x-6">
            <a href="#" class="hover:underline">Privacy Policy</a>
            <a href="#" class="hover:underline">Terms of Service</a>
            <a href="#" class="hover:underline">Contact Support</a>
        </div>
    </footer>

</body>

</html>
