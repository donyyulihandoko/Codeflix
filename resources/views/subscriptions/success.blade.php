<x-app-layout>
    <x-slot:title>Subscription Activated - Codeflix</x-slot>

    <div
        class="w-full min-h-screen bg-zinc-950 text-gray-200 py-16 px-4 sm:px-6 lg:px-8 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-zinc-900/20 via-zinc-950 to-zinc-950 flex items-center justify-center">

        <div
            class="relative w-full max-w-md p-6 space-y-8 overflow-hidden text-center border shadow-2xl bg-zinc-900/30 border-zinc-950/80 shadow-black rounded-3xl sm:p-8 backdrop-blur-xl ring-1 ring-zinc-800/50">

            <div
                class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-emerald-500 via-green-400 to-emerald-600">
            </div>

            <div class="relative flex items-center justify-center w-24 h-24 mx-auto">
                <div
                    class="absolute inset-0 border rounded-full opacity-75 bg-emerald-500/10 border-emerald-500/20 animate-ping">
                </div>
                <div
                    class="relative flex items-center justify-center w-16 h-16 rounded-full shadow-lg bg-gradient-to-tr from-emerald-600 to-green-400 shadow-emerald-950/50">
                    <i class="text-2xl font-black fa-solid fa-check text-zinc-950"></i>
                </div>
            </div>

            <div class="space-y-2">
                <span
                    class="inline-block bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-0.5 text-[9px] font-black uppercase tracking-widest rounded-full">
                    Access Granted
                </span>
                <h1
                    class="text-3xl font-black leading-none tracking-tighter text-transparent uppercase bg-clip-text bg-gradient-to-b from-white via-zinc-200 to-zinc-400">
                    Welcome to the Elite.
                </h1>
                <p class="max-w-xs mx-auto text-xs leading-relaxed text-zinc-500">
                    Your secure billing architecture validation was successful. Your premium account pipeline is now
                    fully operational.
                </p>
            </div>

            <div
                class="relative p-5 space-y-3 text-xs font-medium text-left border shadow-inner bg-zinc-950/80 border-zinc-900 rounded-2xl text-zinc-400">

                <div
                    class="absolute -left-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-zinc-950 border border-zinc-900 rounded-full z-10">
                </div>
                <div
                    class="absolute -right-3.5 top-1/2 -translate-y-1/2 w-7 h-7 bg-zinc-950 border border-zinc-900 rounded-full z-10">
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-zinc-600 font-bold uppercase tracking-wider text-[10px]">Subscriber</span>
                    <span class="text-white font-bold truncate max-w-[180px]">{{ auth()->user()->name }}</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-dashed border-zinc-900">
                    <span class="text-zinc-600 font-bold uppercase tracking-wider text-[10px]">Gateway Ref</span>
                    <span class="text-zinc-500 font-mono text-[11px]">#CFX-{{ time() }}</span>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-zinc-600 font-bold uppercase tracking-wider text-[10px]">Access Layer</span>
                    <span
                        class="text-emerald-400 font-black uppercase tracking-widest text-[9px] bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded shadow-sm">
                        Premium Active
                    </span>
                </div>
            </div>

            <div class="space-y-4">
                <a href="{{ route('dashboard') }}"
                    class="relative flex items-center justify-center w-full gap-2 px-4 py-4 overflow-hidden text-xs font-black tracking-widest text-white uppercase transition-all duration-300 shadow-xl group bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 rounded-xl shadow-red-950/60">
                    <span>Launch Codeflix Terminal</span>
                    <i class="fa-solid fa-chevron-right text-[9px] transition-transform group-hover:translate-x-1"></i>
                </a>

                <div
                    class="flex items-center justify-center space-x-1.5 text-[10px] text-zinc-600 font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-shield-halved text-[11px] text-zinc-700"></i>
                    <span>End-to-End Encrypted Session</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
