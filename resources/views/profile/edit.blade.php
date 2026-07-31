<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status') === 'mahasiswa-updated')
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl text-sm font-medium">
                    Data mahasiswa berhasil disimpan.
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div style="background:linear-gradient(to right,#0c1e3f,#07122e)" class="px-5 py-4">
                    <h3 class="text-sm font-semibold text-white">Informasi Profile</h3>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            @if (!Auth::user()->isAdmin())
            <div class="bg-white rounded-2xl shadow-sm border @if (!$user->mahasiswa || !$user->mahasiswa->nim) border-amber-300 @endif overflow-hidden">
                <div style="background:linear-gradient(to right,@if (!$user->mahasiswa || !$user->mahasiswa->nim) #B45309,#92400e @else #0c1e3f,#07122e @endif)" class="px-5 py-4">
                    <h3 class="text-sm font-semibold text-white">
                        @if (!$user->mahasiswa || !$user->mahasiswa->nim)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                Data Mahasiswa — Harap Lengkapi
                            </span>
                        @else
                            Data Mahasiswa
                        @endif
                    </h3>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-mahasiswa-form')
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div style="background:linear-gradient(to right,#0c1e3f,#07122e)" class="px-5 py-4">
                    <h3 class="text-sm font-semibold text-white">Ubah Password</h3>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 bg-gradient-to-r from-red-700 to-red-800">
                    <h3 class="text-sm font-semibold text-white">Hapus Akun</h3>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
