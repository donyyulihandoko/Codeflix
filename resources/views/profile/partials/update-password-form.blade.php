<section class="space-y-6">
    <header class="space-y-2">
        <h2 class="flex items-center gap-2 text-base font-black tracking-wider text-white uppercase">
            <i class="text-red-600 fa-solid fa-key"></i> {{ __('Update Password') }}
        </h2>

        <p class="max-w-xl text-xs leading-relaxed text-zinc-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div class="space-y-1.5">
            <x-input-label for="update_password_current_password" :value="__('Current Password')"
                class="text-[9px] font-black uppercase tracking-widest text-zinc-400 block" />

            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block w-full bg-zinc-950 border border-zinc-900 text-white placeholder-zinc-700 text-xs rounded-xl p-3.5 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs font-bold text-red-500" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="update_password_password" :value="__('New Password')"
                class="text-[9px] font-black uppercase tracking-widest text-zinc-400 block" />

            <x-text-input id="update_password_password" name="password" type="password"
                class="block w-full bg-zinc-950 border border-zinc-900 text-white placeholder-zinc-700 text-xs rounded-xl p-3.5 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                autocomplete="new-password" placeholder="Minimum 8 characters" />

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs font-bold text-red-500" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')"
                class="text-[9px] font-black uppercase tracking-widest text-zinc-400 block" />

            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full bg-zinc-950 border border-zinc-900 text-white placeholder-zinc-700 text-xs rounded-xl p-3.5 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                autocomplete="new-password" placeholder="Repeat your new password" />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs font-bold text-red-500" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button
                class="px-6 py-3 text-xs font-black tracking-widest text-white uppercase transition duration-200 bg-red-600 shadow-lg hover:bg-red-700 rounded-xl shadow-red-950/40">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center px-3 py-2 space-x-2 text-xs font-bold text-green-400 border rounded-lg bg-green-500/10 border-green-500/20">
                    <i class="fa-solid fa-circle-check text-[11px]"></i>
                    <span>{{ __('Changes saved successfully.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
