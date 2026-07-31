<x-guest-layout>
    <div class="text-center mb-4">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-yellow-500/20 rounded-full mb-3">
            <svg class="w-7 h-7 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-white">Verifikasi Email</h2>
        <p class="text-sm text-blue-200/70 mt-1 leading-relaxed">
            Terima kasih sudah mendaftar! Masukkan kode OTP 6 digit yang terkirim ke {{ auth()->user()->email }}
        </p>
    </div>

    @if (session('info'))
        <div class="mb-4 px-4 py-3 bg-amber-500/10 border border-amber-500/20 rounded-lg text-sm text-amber-300 leading-relaxed">
            {{ session('info') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded-lg text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-lg text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.verify-otp') }}" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="otp" class="block text-sm font-medium text-blue-100 mb-1.5">Kode OTP</label>
            <input id="otp" type="text" name="otp" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required autofocus
                   class="block w-full text-center text-2xl tracking-[0.5em] px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-blue-300/40 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-transparent transition duration-150 ease-in-out"
                   placeholder="000000">
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-400 hover:to-indigo-400 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/25 hover:shadow-blue-400/30 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:ring-offset-0 transition duration-150 ease-in-out">
            Verifikasi
        </button>
    </form>

    <div class="text-center mt-4">
        <form method="POST" action="{{ route('verification.resend-otp') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-blue-300/70 hover:text-blue-200 transition underline">
                Kirim Ulang OTP
            </button>
        </form>

        <span class="text-blue-200/30 mx-2">|</span>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-blue-300/70 hover:text-blue-200 transition underline">
                Logout
            </button>
        </form>
    </div>
</x-guest-layout>
