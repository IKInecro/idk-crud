<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-white">Konfirmasi Password</h2>
        <p class="text-blue-200/70 text-sm mt-1 leading-relaxed">Ini area aman. Harap konfirmasi password kamu sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-blue-100 mb-1.5">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-blue-300/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="block w-full pl-10 pr-3 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-blue-300/40 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-transparent transition duration-150 ease-in-out"
                       placeholder="Masukkan password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold rounded-lg shadow-lg shadow-blue-600/30 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:ring-offset-0 transition duration-150 ease-in-out">
            Konfirmasi
        </button>
    </form>
</x-guest-layout>
