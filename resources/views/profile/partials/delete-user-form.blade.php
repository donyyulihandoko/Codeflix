<section class="space-y-6">
    <header class="space-y-2">
        <h2 class="flex items-center gap-2 text-base font-black tracking-wider text-red-500 uppercase">
            <i class="fa-solid fa-user-xmark"></i> {{ __('Delete Account') }}
        </h2>

        <p class="max-w-xl text-xs leading-relaxed text-zinc-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white border border-red-500/30 px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition duration-200">
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-6 space-y-6 text-gray-200 border sm:p-8 bg-zinc-900 border-zinc-800 rounded-2xl">
            @csrf
            @method('delete')

            <div class="space-y-2">
                <h2 class="flex items-center gap-2 text-lg font-black tracking-tight text-white uppercase">
                    <i class="text-red-500 fa-solid fa-circle-exclamation"></i>
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="text-xs leading-relaxed text-zinc-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="max-w-md space-y-2">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password"
                    class="block w-full p-3 text-xs text-white transition border bg-zinc-950 border-zinc-800 placeholder-zinc-600 rounded-xl focus:border-red-600 focus:ring-1 focus:ring-red-600"
                    placeholder="{{ __('Enter your account password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1 text-xs font-bold text-red-500" />
            </div>

            <div class="flex items-center justify-end pt-4 space-x-3 border-t border-zinc-800/60">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="bg-zinc-950 hover:bg-zinc-800 border border-zinc-800 text-zinc-400 hover:text-white font-bold text-xs uppercase tracking-widest px-4 py-2.5 rounded-xl transition duration-200">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button
                    class="bg-red-600 hover:bg-red-700 text-white font-black text-xs uppercase tracking-widest px-5 py-2.5 rounded-xl shadow-lg shadow-red-950/40 transition duration-200">
                    {{ __('Permanently Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
