<x-guest-layout>
    <x-slot:title>Forgot Password - Codeflix</x-slot>
    <x-slot:pageTitle>Reset Password</x-slot>

    <div class="mb-6 text-sm text-gray-400 leading-relaxed">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset
        link that will allow you to choose a new one.
    </div>

    <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-400 mb-1.5 uppercase tracking-wider">Email
                Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                class="w-full px-4 py-3 rounded bg-zinc-900 border text-white placeholder-gray-500 focus:outline-none focus:bg-zinc-800 transition duration-200
                @error('email') border-red-600 focus:border-red-600 @else border-zinc-700 focus:border-gray-500 @enderror"
                placeholder="name@example.com">

            @error('email')
                <p class="mt-1 text-xs text-red-500"><i class="fa-solid fa-circle-info mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded transition duration-200 tracking-wide shadow-md focus:outline-none">
                Email Password Reset Link
            </button>
        </div>

        <div class="pt-4 text-sm text-gray-500 text-center border-t border-zinc-800/60">
            <a href="{{ route('login') }}" class="text-white hover:underline font-medium transition duration-150">
                <i class="fa-solid fa-arrow-left mr-2 text-xs"></i>Back to Sign In
            </a>
        </div>
    </form>
</x-guest-layout>
