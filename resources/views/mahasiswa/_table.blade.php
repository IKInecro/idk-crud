<table class="min-w-full">
    <thead>
        <tr style="background:#0c1e3f;border-color:#07122e" class="text-white">
            <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wider">Foto</th>
            <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider">NIM</th>
            <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
            <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wider">JK</th>
            <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
            <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider">Jurusan</th>
            <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider">Angkatan</th>
            <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($mahasiswas as $m)
            <tr class="border-b border-gray-50 hover:bg-[#f0f4ff] transition">
                <td class="px-4 py-3 text-center">
                    <img src="{{ $m->foto ? Storage::url($m->foto) : asset('images/profile default.jpeg') }}"
                         class="w-9 h-9 rounded-full object-cover border border-gray-100" alt="Foto">
                </td>
                <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $m->nim }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $m->nama }}</td>
                <td class="px-4 py-3 text-sm text-center">
                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold" style="background:#e8edf5;color:#0c1e3f">{{ $m->jenis_kelamin }}</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $m->email }}</td>
                <td class="px-4 py-3 text-sm"><span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium" style="background:#e8edf5;color:#0c1e3f">{{ $m->jurusan }}</span></td>
                <td class="px-4 py-3 text-sm"><span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium" style="background:rgba(217,119,6,0.15);color:#D97706">{{ $m->angkatan }}</span></td>
                <td class="px-4 py-3 text-sm text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button type="button"
                            data-id="{{ $m->id }}"
                            data-nim="{{ $m->nim }}"
                            data-nama="{{ $m->nama }}"
                            data-kelamin="{{ $m->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                            data-jurusan="{{ $m->jurusan }}"
                            data-angkatan="{{ $m->angkatan }}"
                            data-tgl-lahir="{{ $m->tgl_lahir?->format('d/m/Y') }}"
                            data-alamat="{{ $m->alamat ?? '-' }}"
                            data-foto="{{ $m->foto ? Storage::url($m->foto) : asset('images/profile default.jpeg') }}"
                            class="showCardBtn p-2 rounded-xl transition" style="color:#0c1e3f;background:#e8edf5" onmouseover="this.style.background='#0c1e3f';this.style.color='white'" onmouseout="this.style.background='#e8edf5';this.style.color='#0c1e3f'"
                            title="Lihat Kartu">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </button>
                        @can('update', $m)
                            <a href="{{ route('mahasiswa.edit', $m) }}" class="p-2 text-amber-600 hover:text-amber-800 bg-amber-100 hover:bg-amber-200 rounded-xl transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                        @endcan
                        @can('delete', $m)
                            <button type="button"
                                data-delete-url="{{ route('mahasiswa.destroy', $m) }}"
                                data-nama="{{ $m->nama }}"
                                class="deleteMahasiswaBtn p-2 text-red-500 hover:text-red-700 bg-red-100 hover:bg-red-200 rounded-xl transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        @endcan
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-4 py-8 text-center text-gray-300">Belum ada data mahasiswa.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $mahasiswas->links() }}
</div>
