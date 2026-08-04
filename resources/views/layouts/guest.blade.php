<!doctype html>
<html lang="en" class="h-full bg-black">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Codeflix' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="h-full text-gray-200 antialiased font-sans">

    <div class="relative grid min-h-screen grid-cols-12 items-center bg-cover bg-center bg-no-repeat before:absolute before:inset-0 before:bg-black/65"
        style="background-image: url('https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=1920');">

        <div class="absolute top-6 left-6 z-10 sm:left-12">
            <a href="/" class="text-3xl font-extrabold tracking-tighter text-red-600 sm:text-4xl">
                CODEFLIX
            </a>
        </div>

        <div
            class="relative col-span-12 px-4 py-24 sm:px-6 md:col-span-6 md:col-start-7 lg:col-span-5 lg:col-start-8 xl:col-span-4 xl:col-start-9 z-10">

            <div
                class="w-full bg-black/80 p-8 sm:p-14 rounded-md shadow-2xl border border-zinc-800/50 backdrop-blur-sm">

                <h2 class="text-3xl font-bold text-white mb-7">{{ $pageTitle ?? 'Sign Up' }}</h2>

                {{ $slot }}

            </div>

        </div>
    </div>

    {{ $scripts ?? '' }}
    <x-alert />
</body>

</html>
