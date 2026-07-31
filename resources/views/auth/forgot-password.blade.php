<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-white">Lupa Password</h2>
        <p class="text-blue-200/70 text-sm mt-1 leading-relaxed">Masukkan email kamu dan kami akan kirim link reset password.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-blue-100 mb-1.5">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-blue-300/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                       class="block w-full pl-10 pr-3 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-blue-300/40 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-transparent transition duration-150 ease-in-out"
                       placeholder="email@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold rounded-lg shadow-lg shadow-blue-600/30 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:ring-offset-0 transition duration-150 ease-in-out">
            Kirim Link Reset
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-blue-300 hover:text-blue-200 font-medium transition">Kembali ke Login</a>
        </div>
    </form>
</x-guest-layout>
