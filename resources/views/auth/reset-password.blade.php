<x-guest-layout>
    <x-slot:title>Reset Password - Codeflix</x-slot>
    <x-slot:pageTitle>Create New Password</x-slot>

    <form action="{{ route('password.store') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wider">Email
                Address</label>
            <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required
                autofocus
                class="w-full px-4 py-3 rounded bg-zinc-900 border text-white placeholder-gray-500 focus:outline-none focus:bg-zinc-800 transition duration-200
                @error('email') border-red-600 focus:border-red-600 @else border-zinc-700 focus:border-gray-500 @enderror">

            @error('email')
                <p class="mt-1 text-xs text-red-500"><i class="fa-solid fa-circle-info mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wider">New
                Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 pr-10 rounded bg-zinc-900 border text-white placeholder-gray-500 focus:outline-none focus:bg-zinc-800 transition duration-200
                    @error('password') border-red-600 focus:border-red-600 @else border-zinc-700 focus:border-gray-500 @enderror">
                <i
                    class="fa-solid fa-eye-slash toggle-password absolute right-3 top-4 text-gray-400 hover:text-white cursor-pointer text-sm"></i>
            </div>

            @error('password')
                <p class="mt-1 text-xs text-red-500"><i class="fa-solid fa-circle-info mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation"
                class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wider">Confirm New
                Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-3 pr-10 rounded bg-zinc-900 border border-zinc-700 text-white placeholder-gray-500 focus:outline-none focus:bg-zinc-800 focus:border-gray-500 transition duration-200">
                <i
                    class="fa-solid fa-eye-slash toggle-password absolute right-3 top-4 text-gray-400 hover:text-white cursor-pointer text-sm"></i>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded transition duration-200 tracking-wide shadow-md focus:outline-none">
                Reset Password
            </button>
        </div>
    </form>

    <x-slot:scripts>
        <script>
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });
        </script>
    </x-slot>
</x-guest-layout>
