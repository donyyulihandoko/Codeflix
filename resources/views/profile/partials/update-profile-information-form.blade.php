<section class="space-y-6">
    <header class="space-y-2">
        <h2 class="flex items-center gap-2 text-base font-black tracking-wider text-white uppercase">
            <i class="text-red-600 fa-solid fa-id-card"></i> {{ __('Profile Information') }}
        </h2>

        <p class="max-w-xl text-xs leading-relaxed text-zinc-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div class="space-y-1.5">
            <x-input-label for="name" :value="__('Name')"
                class="text-[9px] font-black uppercase tracking-widest text-zinc-400 block" />

            <x-text-input id="name" name="name" type="text"
                class="block w-full bg-zinc-950 border border-zinc-900 text-white placeholder-zinc-700 text-xs rounded-xl p-3.5 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Your full name" />

            <x-input-error class="mt-1 text-xs font-bold text-red-500" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')"
                class="text-[9px] font-black uppercase tracking-widest text-zinc-400 block" />

            <x-text-input id="email" name="email" type="email"
                class="block w-full bg-zinc-950 border border-zinc-900 text-white placeholder-zinc-700 text-xs rounded-xl p-3.5 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                :value="old('email', $user->email)" required autocomplete="username" placeholder="yourname@example.com" />

            <x-input-error class="mt-1 text-xs font-bold text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="p-4 mt-3 space-y-2 border bg-yellow-500/5 border-yellow-500/20 rounded-xl">
                    <p class="flex items-center gap-2 text-xs font-medium text-yellow-500/90">
                        <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
                        <span>{{ __('Your email address is unverified.') }}</span>
                    </p>

                    <button form="send-verification"
                        class="text-[11px] text-zinc-400 hover:text-white underline decoration-zinc-600 hover:decoration-white font-bold transition duration-150 block focus:outline-none">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-[11px] text-green-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-paper-plane text-[10px]"></i>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button
                class="px-6 py-3 text-xs font-black tracking-widest text-white uppercase transition duration-200 bg-red-600 shadow-lg hover:bg-red-700 rounded-xl shadow-red-950/40">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center px-3 py-2 space-x-2 text-xs font-bold text-green-400 border rounded-lg bg-green-500/10 border-green-500/20">
                    <i class="fa-solid fa-circle-check text-[11px]"></i>
                    <span>{{ __('Profile updated successfully.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
