<x-app-layout>
    <x-slot:title>Choose Your Premium Plan - Codeflix</x-slot>

    <div class="w-full min-h-screen px-4 py-20 text-gray-200 bg-zinc-950 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto mb-16 space-y-4 text-center">
            <span
                class="px-3 py-1 text-xs font-black tracking-widest text-red-500 uppercase border rounded-full bg-red-600/10 border-red-500/20">
                Codeflix Premium
            </span>
            <h1 class="text-3xl font-black leading-none tracking-tight text-white uppercase sm:text-5xl">
                Flexible Plans for Every Movie Lover.
            </h1>
            <p class="max-w-xl mx-auto text-sm leading-relaxed sm:text-base text-zinc-400">
                Cancel or upgrade anytime. Choose the tier that matches your cinematic experience.
            </p>
        </div>

        @livewire('plan-list')

    </div>
</x-app-layout>
