<x-app-layout>
    <x-slot:title>Account Settings - Codeflix</x-slot>

    <div
        class="w-full min-h-screen bg-zinc-950 text-gray-200 py-12 px-4 sm:px-6 lg:px-8 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-900/30 via-zinc-950 to-zinc-950">
        <div class="max-w-4xl mx-auto space-y-8">

            <div class="pb-6 space-y-1 border-b border-zinc-900">
                <h1 class="flex items-center gap-3 text-2xl font-black tracking-tight text-white uppercase sm:text-3xl">
                    <i class="text-red-600 fa-solid fa-user-gear"></i> Account Settings
                </h1>
                <p class="text-xs text-zinc-500">Manage your profile information, security credentials, and account
                    state.</p>
            </div>

            <div class="overflow-hidden border shadow-2xl bg-zinc-900/30 border-zinc-900 rounded-2xl backdrop-blur-md">
                <div class="grid items-start grid-cols-1 gap-6 p-6 sm:p-8 md:grid-cols-12">
                    <div class="space-y-1 md:col-span-4">
                        <h3 class="text-sm font-black tracking-wider text-white uppercase">Profile Information</h3>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Update your account's profile information
                            and email address.</p>
                    </div>
                    <div class="w-full max-w-xl p-6 border md:col-span-8 bg-zinc-950/40 border-zinc-900/60 rounded-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border shadow-2xl bg-zinc-900/30 border-zinc-900 rounded-2xl backdrop-blur-md">
                <div class="grid items-start grid-cols-1 gap-6 p-6 sm:p-8 md:grid-cols-12">
                    <div class="space-y-1 md:col-span-4">
                        <h3 class="text-sm font-black tracking-wider text-white uppercase">Update Password</h3>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Ensure your account is using a long, random
                            password to stay secure.</p>
                    </div>
                    <div class="w-full max-w-xl p-6 border md:col-span-8 bg-zinc-950/40 border-zinc-900/60 rounded-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border shadow-2xl bg-red-950/10 border-red-950/40 rounded-2xl backdrop-blur-md">
                <div class="grid items-start grid-cols-1 gap-6 p-6 sm:p-8 md:grid-cols-12">
                    <div class="space-y-1 md:col-span-4">
                        <h3 class="text-sm font-black text-red-500 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="text-xs fa-solid fa-triangle-exclamation"></i> Danger Zone
                        </h3>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Once your account is deleted, all of its
                            resources and data will be permanently wiped.</p>
                    </div>
                    <div class="w-full max-w-xl p-6 border md:col-span-8 bg-zinc-950/20 border-red-950/20 rounded-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
