<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Mahasiswa</h2>
            <div class="flex gap-2">
                @can('create', App\Models\Mahasiswa::class)
                    <a href="{{ route('mahasiswa.create') }}" style="background:#0c1e3f" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#07122e] focus:outline-none focus:ring-2 focus:ring-[#8ba3d6] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl text-sm font-medium shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div style="background:linear-gradient(to right,#0c1e3f,#07122e)" class="px-5 py-4 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-white">Daftar Mahasiswa</h3>
                    <span class="text-xs" style="color:#8ba3d6">{{ $mahasiswas->total() }} mahasiswa</span>
                </div>
                <div class="p-4 border-b border-gray-100">
                    <form method="GET" action="{{ route('mahasiswa.index') }}" id="filterForm">
                        <div class="flex flex-wrap items-end gap-3">
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-xs text-gray-500 mb-1.5 font-medium">Cari</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="NIM, Nama, Email..." class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-[#8ba3d6] focus:border-[#0c1e3f]">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1.5 font-medium">Fakultas</label>
                                <select name="fakultas" class="py-2.5 px-3 border border-gray-300 rounded-xl text-sm focus:ring-[#8ba3d6] focus:border-[#0c1e3f]">
                                    <option value="">Semua</option>
                                    @foreach (\App\Http\Controllers\MahasiswaController::fakultasList() as $fak => $prodi)
                                        <option value="{{ $fak }}" @selected(request('fakultas') == $fak)>{{ $fak }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1.5 font-medium">Jurusan</label>
                                <select name="jurusan" class="py-2.5 px-3 border border-gray-300 rounded-xl text-sm focus:ring-[#8ba3d6] focus:border-[#0c1e3f]">
                                    <option value="">Semua</option>
                                    @foreach ($jurusanList as $j)
                                        <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1.5 font-medium">Angkatan</label>
                                <select name="angkatan" class="py-2.5 px-3 border border-gray-300 rounded-xl text-sm focus:ring-[#8ba3d6] focus:border-[#0c1e3f]">
                                    <option value="">Semua</option>
                                    @foreach ($angkatanList as $a)
                                        <option value="{{ $a }}" @selected(request('angkatan') == $a)>{{ $a }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" style="background:#0c1e3f" class="py-2.5 px-4 text-white text-sm font-medium rounded-xl hover:bg-[#07122e] transition shadow-sm">
                                    Filter
                                </button>
                                @if (request()->anyFilled(['search', 'fakultas', 'jurusan', 'angkatan']))
                                    <a href="{{ route('mahasiswa.index') }}" class="py-2.5 px-4 bg-gray-100 text-gray-500 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6 overflow-x-auto" id="tableWrapper">
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
                                             class="w-9 h-9 rounded-full object-cover border border-gray-100"
                                             alt="Foto">
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
                </div>
            </div>
        </div>
    </div>

    <div id="cardModal" class="fixed inset-0 z-50" style="display:none;background:rgba(0,0,0,0.8);align-items:center;justify-content:center;padding:16px">
        <div style="position:relative;width:560px;max-width:100%">
            <button id="closeCardModal" style="position:absolute;top:-14px;right:-14px;z-index:10;width:32px;height:32px;background:white;border-radius:50%;border:none;box-shadow:0 2px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4b5563" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div id="cardInner" style="border-radius:12px;overflow:hidden;background:linear-gradient(145deg,#0c1e3f,#07122e);max-width:100%;width:560px;display:flex;flex-direction:column;border:1px solid rgba(180,83,9,0.15);box-shadow:0 0 40px rgba(0,0,0,0.5),inset 0 1px 0 rgba(255,255,255,0.06)">
                <div style="height:46px;flex-shrink:0;display:flex;align-items:center;justify-content:space-between;padding:0 24px">
                    <img src="{{ asset('images/logocrd.png') }}" alt="MNC" style="height:28px;width:auto">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:5px;height:5px;border-radius:50%;background:#D97706"></div>
                        <span style="color:#D97706;font-size:10px;font-weight:700;letter-spacing:0.3em">PROFILE</span>
                        <div style="width:5px;height:5px;border-radius:50%;background:#D97706"></div>
                    </div>
                    <img src="{{ asset('images/logo.png') }}" alt="MNC" style="height:28px;width:auto">
                </div>

                <div style="flex:1;display:flex;gap:20px;padding:8px 24px 16px 24px;min-height:0">
                    <div style="width:180px;height:225px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#1a2d55;border:1.5px solid rgba(255,255,255,0.1)">
                        <img id="cardFoto" style="width:100%;height:100%;object-fit:cover;display:block" alt="Foto">
                    </div>

                    <div style="flex:1;display:flex;flex-direction:column;justify-content:center;min-width:0;gap:0">
                        <div style="border-bottom:1px solid rgba(255,255,255,0.07);padding:4px 0">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.2em">N I M</span>
                            <p id="cardNim" style="margin:0;color:#fff;font-size:17px;font-weight:700;letter-spacing:0.04em;line-height:1.3"></p>
                        </div>
                        <div style="border-bottom:1px solid rgba(255,255,255,0.07);padding:4px 0">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.2em">NAMA</span>
                            <p id="cardNama" style="margin:0;color:#fff;font-size:15px;font-weight:500;line-height:1.3"></p>
                        </div>
                        <div style="border-bottom:1px solid rgba(255,255,255,0.07);padding:4px 0">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.2em">LAHIR</span>
                            <p id="cardTglLahir" style="margin:0;color:#d1d5db;font-size:13px;font-weight:400;line-height:1.3"></p>
                        </div>
                        <div style="border-bottom:1px solid rgba(255,255,255,0.07);padding:4px 0">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.2em">ALAMAT</span>
                            <p id="cardAlamat1" style="margin:0;color:#d1d5db;font-size:13px;font-weight:400;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"></p>
                        </div>
                        <div style="padding:4px 0">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.2em">KELAMIN</span>
                            <p id="cardKelamin" style="margin:0;color:#9ca3af;font-size:13px;font-weight:400;line-height:1.3"></p>
                        </div>
                    </div>
                </div>

                <div style="height:30px;flex-shrink:0;border-top:1px solid rgba(255,255,255,0.06);background:rgba(0,0,0,0.15);display:flex;align-items:center;justify-content:space-between;padding:0 24px">
                    <div style="display:flex;align-items:center;gap:14px;flex:1;min-width:0">
                        <div style="display:flex;align-items:center;gap:5px">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.12em">JURUSAN</span>
                            <span id="cardJurusan" style="color:#d1d5db;font-size:10.5px"></span>
                        </div>
                        <div style="width:1px;height:12px;background:rgba(255,255,255,0.06);flex-shrink:0"></div>
                        <div style="display:flex;align-items:center;gap:5px">
                            <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.12em">ANGKATAN</span>
                            <span id="cardAngkatan" style="color:#d1d5db;font-size:10.5px"></span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;margin-left:12px">
                        <span style="color:#D97706;font-size:7px;font-weight:700;letter-spacing:0.12em">STATUS</span>
                        <span id="cardStatus" style="color:#fbbf24;font-size:9px;font-weight:700">AKTIF</span>
                        <div style="width:1px;height:12px;background:rgba(255,255,255,0.06)"></div>
                        <span style="color:#8ba3d6;font-size:7px;font-weight:600;letter-spacing:0.12em">BERLAKU</span>
                        <span style="color:#d1d5db;font-size:9px;font-weight:500">2028</span>
                    </div>
                </div>
            </div>
    </div>
</div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;background:rgba(0,0,0,0.7)">
        <div class="relative w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden" style="background:linear-gradient(145deg,#0c1e3f,#07122e)">
            <div class="p-6 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-3" style="background:rgba(220,38,38,0.15)">
                    <svg class="w-6 h-6" style="color:#ef4444" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white">Hapus Data Mahasiswa?</h3>
                <p class="text-sm mt-1 leading-relaxed" style="color:#8ba3d6">Yakin ingin menghapus <span id="deleteNama" class="font-semibold" style="color:#fff"></span>? Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button type="button" id="cancelDeleteBtn"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition"
                        style="background:rgba(255,255,255,0.08);color:#8ba3d6" onmouseover="this.style.background='rgba(255,255,255,0.14)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    Batal
                </button>
                <button type="button" id="confirmDeleteBtn"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold text-white transition shadow-lg"
                        style="background:linear-gradient(to right,#dc2626,#b91c1c);box-shadow:0 8px 20px -6px rgba(220,38,38,0.5)" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="POST" action="" style="display:none">
        @csrf
        @method('DELETE')
    </form>

    <script>
    (function() {
        var modal = document.getElementById('cardModal');

        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.showCardBtn');
            if (btn) {
                document.getElementById('cardFoto').src = btn.getAttribute('data-foto');
                document.getElementById('cardNim').textContent = btn.getAttribute('data-nim');
                document.getElementById('cardNama').textContent = btn.getAttribute('data-nama');
                document.getElementById('cardJurusan').textContent = btn.getAttribute('data-jurusan');
                document.getElementById('cardAngkatan').textContent = btn.getAttribute('data-angkatan');
                document.getElementById('cardKelamin').textContent = btn.getAttribute('data-kelamin');
                document.getElementById('cardTglLahir').textContent = btn.getAttribute('data-tgl-lahir');
                document.getElementById('cardAlamat1').textContent = btn.getAttribute('data-alamat');
                modal.style.display = 'flex';
            }
        });

        document.getElementById('closeCardModal').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        modal.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });

        var wrapper = document.getElementById('tableWrapper');
        var form = document.getElementById('filterForm');
        var timer;

        function fetchTable() {
            var params = new URLSearchParams(new FormData(form));
            params.set('_live', '1');
            var url = form.action + '?' + params.toString();

            wrapper.innerHTML = '<div class="py-8 text-center text-gray-400">Memuat...</div>';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.text(); })
                .then(function(html) {
                    wrapper.innerHTML = html;
                });
        }

        function debounceFetch() {
            clearTimeout(timer);
            timer = setTimeout(fetchTable, 400);
        }

        form.addEventListener('submit', function(e) { e.preventDefault(); fetchTable(); });

        var resetLink = form.querySelector('a[href="{{ route('mahasiswa.index') }}"]');
        if (resetLink) {
            resetLink.addEventListener('click', function(e) {
                e.preventDefault();
                form.querySelectorAll('input, select').forEach(function(el) {
                    if (el.name !== 'page') el.value = '';
                });
                fetchTable();
            });
        }

        wrapper.addEventListener('click', function(e) {
            var pageLink = e.target.closest('a[href*="page="]');
            if (pageLink) {
                e.preventDefault();
                var url = new URL(pageLink.href);
                form.querySelectorAll('input, select').forEach(function(el) {
                    if (url.searchParams.has(el.name)) {
                        el.value = url.searchParams.get(el.name);
                    }
                });
                fetchTable();
            }
        });

        var inputs = form.querySelectorAll('input[name="search"]');
        var selects = form.querySelectorAll('select');
        inputs.forEach(function(el) { el.addEventListener('input', debounceFetch); });
        selects.forEach(function(el) { el.addEventListener('change', debounceFetch); });
    })();

    // Delete confirmation modal
    (function() {
        var modal = document.getElementById('deleteModal');
        var namaEl = document.getElementById('deleteNama');
        var deleteForm = document.getElementById('deleteForm');

        function openDeleteModal(btn) {
            namaEl.textContent = btn.getAttribute('data-nama');
            deleteForm.action = btn.getAttribute('data-delete-url');
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            modal.style.display = 'none';
        }

        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.deleteMahasiswaBtn');
            if (btn) { e.preventDefault(); openDeleteModal(btn); }
        });

        document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteForm.submit();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeDeleteModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    })();
    </script>
</x-app-layout>
