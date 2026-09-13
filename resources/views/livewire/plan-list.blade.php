<div>
    <div class="grid items-stretch max-w-5xl grid-cols-1 gap-8 mx-auto md:grid-cols-3">
        @foreach ($plans as $plan)
            @php
                // Deteksi paket premium/terpopuler berdasarkan title/slug paket
                $isPopular = Str::contains(strtolower($plan->title), ['premium', 'gold', 'popular', '4k']);
            @endphp

            <div
                class="relative flex flex-col justify-between bg-zinc-900/40 border {{ $isPopular ? 'border-red-600 shadow-2xl shadow-red-950/20 scale-105 z-10' : 'border-zinc-900 shadow-xl' }} p-6 sm:p-8 rounded-2xl backdrop-blur-sm transition duration-300 hover:border-zinc-700">

                @if ($isPopular)
                    <span
                        class="absolute -top-3 left-1/2 -translate-x-1/2 bg-red-600 text-white font-black uppercase text-[10px] tracking-widest px-3 py-1 rounded-full shadow-md">
                        Most Popular
                    </span>
                @endif

                <div class="space-y-6">
                    <div class="space-y-2">
                        <h3 class="text-lg font-black tracking-wider text-white uppercase">
                            {{ $plan->title }} </h3>
                        <p class="text-xs text-zinc-500">
                            Enjoy unlimited streaming with our {{ $plan->title }} package tier.
                        </p>
                    </div>

                    <div class="flex items-baseline text-white">
                        <span class="text-xl font-bold tracking-tight">Rp</span>
                        <span class="mx-1 text-4xl font-black tracking-tight sm:text-5xl">
                            {{ number_format($plan->price, 0, ',', '.') }}
                        </span>
                        <span class="text-xs font-semibold tracking-wider uppercase text-zinc-500">/
                            {{ $plan->duration }} Days</span>
                    </div>

                    <div class="h-[1px] bg-zinc-800/60 w-full"></div>

                    <ul class="space-y-3 text-xs font-medium text-zinc-400">
                        <li class="flex items-center space-x-3">
                            <i
                                class="fa-solid fa-check {{ $isPopular ? 'text-red-500' : 'text-zinc-500' }} text-[11px]"></i>
                            <span>Unlimited streaming access</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i
                                class="fa-solid fa-video {{ $isPopular ? 'text-red-500' : 'text-zinc-500' }} text-[11px]"></i>
                            <span>Max Resolution: <strong
                                    class="text-white uppercase">{{ $plan->resolution }}</strong></span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i
                                class="fa-solid fa-laptop {{ $isPopular ? 'text-red-500' : 'text-zinc-500' }} text-[11px]"></i>
                            <span>Watch on <strong class="text-white">{{ $plan->max_devices }}</strong>
                                {{ $plan->max_devices > 1 ? 'devices' : 'device' }} simultaneously</span>
                        </li>
                    </ul>
                </div>

                <div class="pt-4 mt-8">

                    <a href="{{ route('subscriptions.show', $plan) }}" type="submit"
                        class="w-full text-center block font-black text-xs uppercase tracking-widest py-3.5 px-4 rounded-xl transition duration-200
                                    {{ $isPopular
                                        ? 'bg-red-600 hover:bg-red-700 text-white shadow-lg shadow-red-900/30'
                                        : 'bg-zinc-800 hover:bg-zinc-700 text-zinc-200 hover:text-white' }}">
                        Choose {{ $plan->title }}
                    </a>

                </div>

            </div>
        @endforeach
    </div>

    {{-- pagination start --}}
    <div
        class="mt-10 text-zinc-400 [&_button]:bg-zinc-900 [&_button]:border [&_button]:border-zinc-800 [&_button]:rounded-lg [&_button]:px-4 [&_button]:py-2 [&_button:hover]:bg-zinc-800 [&_button:hover]:text-white">
        {{ $plans->links('livewire::simple-tailwind') }}
    </div>
    {{-- pagination end --}}
</div>
