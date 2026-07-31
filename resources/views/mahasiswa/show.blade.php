<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Mahasiswa</h2>
            <div class="flex gap-2">
                @can('update', $mahasiswa)
                    <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('mahasiswa.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="shrink-0">
                            <img src="{{ $mahasiswa->foto ? Storage::url($mahasiswa->foto) : asset('images/profile default.jpeg') }}"
                                 class="w-32 h-32 object-cover rounded-lg border" alt="Foto">
                        </div>
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">NIM</p>
                                <p class="font-medium">{{ $mahasiswa->nim }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Nama</p>
                                <p class="font-medium">{{ $mahasiswa->nama }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Jenis Kelamin</p>
                                <p class="font-medium">{{ $mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($mahasiswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Email</p>
                                <p class="font-medium">{{ $mahasiswa->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Jurusan</p>
                                <p class="font-medium">{{ $mahasiswa->jurusan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Angkatan</p>
                                <p class="font-medium">{{ $mahasiswa->angkatan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Tanggal Lahir</p>
                                <p class="font-medium">{{ $mahasiswa->tgl_lahir?->format('d/m/Y') }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 uppercase">Alamat</p>
                                <p class="font-medium">{{ $mahasiswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
