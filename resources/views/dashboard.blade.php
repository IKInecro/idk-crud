<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php $mhs = Auth::user()->mahasiswa; @endphp
            @if (!Auth::user()->isAdmin() && (!$mhs || !$mhs->nim))
            <div class="mb-6">
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-amber-800 text-sm">Profil Mahasiswa Belum Lengkap</p>
                            <p class="text-xs text-amber-600 mt-0.5">Lengkapi data NIM, jurusan, dan lainnya untuk mengaktifkan akun mahasiswa Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="shrink-0 inline-flex items-center px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Lengkapi Profile
                    </a>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div style="background:linear-gradient(145deg,#0c1e3f,#07122e)" class="rounded-2xl shadow-md p-5 text-white">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/10 rounded-xl">
                            <img src="{{ asset('images/pople.svg') }}" alt="Mahasiswa" class="w-7 h-7" style="filter:brightness(0) saturate(100%) invert(1)">
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-medium" style="color:#8ba3d6">Total Mahasiswa</p>
                            <p class="text-2xl font-bold">{{ \App\Models\Mahasiswa::count() }}</p>
                        </div>
                    </div>
                </div>

                <div style="background:linear-gradient(145deg,#0c1e3f,#07122e)" class="rounded-2xl shadow-md p-5 text-white">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-500/15 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-medium" style="color:#8ba3d6">Total User</p>
                            <p class="text-2xl font-bold">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>

                <div style="background:linear-gradient(145deg,#0c1e3f,#07122e)" class="rounded-2xl shadow-md p-5 text-white">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-amber-500/15 rounded-xl">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-medium" style="color:#8ba3d6">Jurusan</p>
                            <p class="text-2xl font-bold">{{ \App\Models\Mahasiswa::distinct('jurusan')->count('jurusan') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div style="background:linear-gradient(to right,#0c1e3f,#07122e)" class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-white text-sm">Mahasiswa Terbaru</h3>
                        <a href="{{ route('mahasiswa.index') }}" class="text-xs font-medium" style="color:#8ba3d6">Lihat Semua</a>
                    </div>
                    <div class="p-5">
                        @php $latest = \App\Models\Mahasiswa::latest()->take(3)->get(); @endphp
                        @if ($latest->count())
                            <div class="space-y-2">
                                @foreach ($latest as $m)
                                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-[#f0f4ff] transition">
                                        <div class="w-10 h-10 bg-[#e8edf5] text-[#0c1e3f] rounded-xl flex items-center justify-center text-sm font-bold uppercase">
                                            {{ substr($m->nama, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $m->nama }}</p>
                                            <p class="text-xs text-gray-400">{{ $m->nim }} · {{ $m->jurusan }}</p>
                                        </div>
                                        <a href="{{ route('mahasiswa.show', $m) }}" class="text-gray-300 hover:text-[#0c1e3f] transition p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 text-center py-4">Belum ada data.</p>
                        @endif
                    </div>
                </div>

                @if (Auth::user()->isAdmin())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div style="background:linear-gradient(to right,#0c1e3f,#07122e)" class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-white text-sm">Akses Cepat</h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-3">
                            <a href="{{ route('mahasiswa.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-gray-100 hover:border-[#0c1e3f] hover:bg-[#f0f4ff] transition group">
                                <svg class="w-6 h-6 text-[#0c1e3f] group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span class="text-xs font-medium text-gray-600">Data Mahasiswa</span>
                            </a>
                            <a href="{{ route('mahasiswa.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-gray-100 hover:border-emerald-400 hover:bg-emerald-50 transition group">
                                <svg class="w-6 h-6 text-emerald-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span class="text-xs font-medium text-gray-600">Tambah</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-gray-100 hover:border-[#D97706] hover:bg-amber-50 transition group">
                                <svg class="w-6 h-6 text-[#D97706] group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-xs font-medium text-gray-600">Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div style="background:linear-gradient(145deg,#0c1e3f,#07122e)" class="mt-6 rounded-2xl shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Sistem Informasi Akademik</h3>
                        <p class="text-sm mt-1" style="color:#8ba3d6">MNC University — Kelola data mahasiswa dengan mudah dan cepat.</p>
                    </div>
                    <div class="hidden md:flex gap-2">
                        <span class="px-3 py-1 bg-white/10 rounded-full text-xs font-semibold" style="color:#8ba3d6">
                            {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                        </span>
                        @if (Auth::user()->isAdmin())
                        <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:rgba(217,119,6,0.15);color:#D97706">Mahasiswa: {{ \App\Models\Mahasiswa::count() }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>