<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Mahasiswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div style="background:linear-gradient(to right,#0c1e3f,#07122e)" class="px-5 py-4">
                    <h3 class="text-sm font-semibold text-white">Tambah Mahasiswa</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('mahasiswa.store') }}" enctype="multipart/form-data" id="mahasiswaForm">
                        @csrf

                        <div class="mb-6">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Data Pribadi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="nim" :value="__('NIM')" />
                                    <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" required maxlength="20" placeholder="Contoh: 220102001" />
                                    <p class="text-xs mt-1 text-gray-400">NIM tanpa spasi</p>
                                    <x-input-error :messages="$errors->get('nim')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required placeholder="Nama lengkap" />
                                    <x-input-error :messages="$errors->get('nama')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="L" @checked(old('jenis_kelamin') == 'L') required class="text-[#0c1e3f] focus:ring-blue-300">
                                            <span class="text-sm text-gray-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="P" @checked(old('jenis_kelamin') == 'P') required class="text-[#0c1e3f] focus:ring-blue-300">
                                            <span class="text-sm text-gray-700">Perempuan</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="mahasiswa@example.com" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir')" required />
                                    <x-input-error :messages="$errors->get('tgl_lahir')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Data Akademik</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="jurusan" :value="__('Jurusan')" />
                                    <select id="jurusan" name="jurusan" class="border-gray-300 focus:border-gray-900 focus:ring-blue-300 rounded-xl shadow-sm w-full mt-1" required>
                                        <option value="">Pilih Jurusan</option>
                                        <optgroup label="Fakultas Bisnis dan Keuangan">
                                            <option value="Manajemen" @selected(old('jurusan') == 'Manajemen')>Manajemen</option>
                                            <option value="Akuntansi" @selected(old('jurusan') == 'Akuntansi')>Akuntansi</option>
                                            <option value="Pendidikan Matematika" @selected(old('jurusan') == 'Pendidikan Matematika')>Pendidikan Matematika</option>
                                        </optgroup>
                                        <optgroup label="Fakultas Industri Kreatif">
                                            <option value="Pendidikan Bahasa Inggris" @selected(old('jurusan') == 'Pendidikan Bahasa Inggris')>Pendidikan Bahasa Inggris</option>
                                            <option value="Sains Komunikasi" @selected(old('jurusan') == 'Sains Komunikasi')>Sains Komunikasi</option>
                                            <option value="Desain Komunikasi Visual" @selected(old('jurusan') == 'Desain Komunikasi Visual')>Desain Komunikasi Visual</option>
                                            <option value="Sistem Informasi" @selected(old('jurusan') == 'Sistem Informasi')>Sistem Informasi</option>
                                            <option value="Ilmu Komputer" @selected(old('jurusan') == 'Ilmu Komputer')>Ilmu Komputer</option>
                                        </optgroup>
                                    </select>
                                    <x-input-error :messages="$errors->get('jurusan')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="angkatan" :value="__('Angkatan')" />
                                    <select id="angkatan" name="angkatan" class="border-gray-300 focus:border-gray-900 focus:ring-blue-300 rounded-xl shadow-sm w-full mt-1" required>
                                        <option value="">Pilih Tahun</option>
                                        @for ($y = date('Y'); $y >= 2021; $y--)
                                            <option value="{{ $y }}" @selected(old('angkatan') == $y)>{{ $y }}</option>
                                        @endfor
                                    </select>
                                    <x-input-error :messages="$errors->get('angkatan')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Alamat & Foto</h4>

                            <div class="mb-4">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap" class="border-gray-300 focus:border-gray-900 focus:ring-blue-300 rounded-xl shadow-sm w-full mt-1">{{ old('alamat') }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="foto" :value="__('Foto (max 2MB, jpg/png)')" />
                                <input id="fotoInput" type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-800 hover:file:bg-gray-200 file:transition mt-1" />
                                <div id="previewContainer" class="mt-2 hidden">
                                    <img id="preview" class="max-w-full max-h-48 rounded-xl border border-gray-200">
                                </div>
                                <x-input-error :messages="$errors->get('foto')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100">
                            <a href="{{ route('mahasiswa.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Batal
                            </a>
                            <button type="submit" style="background:#0c1e3f" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm" onmouseover="this.style.background='#07122e'" onmouseout="this.style.background='#0c1e3f'">
                                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="cropModal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                <h3 class="font-semibold text-gray-800 text-lg">Crop Foto</h3>
                <select id="aspectRatio" class="text-sm border border-gray-300 rounded-xl px-3 py-1.5">
                    <option value="3/4">3 x 4</option>
                    <option value="1/1">1 x 1</option>
                    <option value="NaN">Free</option>
                </select>
            </div>
            <div class="flex-1 min-h-0 bg-gray-100 flex items-center justify-center p-2">
                <img id="cropImage" class="max-w-full max-h-[65vh]">
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button id="cancelCrop" class="px-5 py-2 bg-gray-100 text-gray-500 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Batal</button>
                <button id="confirmCrop" style="background:#0c1e3f" class="px-5 py-2 text-white rounded-xl text-sm font-medium transition shadow-sm" onmouseover="this.style.background='#07122e'" onmouseout="this.style.background='#0c1e3f'">Simpan Crop</button>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/cropper.min.js') }}"></script>
<script>
let cropper = null;

document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2MB.');
        this.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(ev) {
        const img = document.getElementById('cropImage');
        img.src = ev.target.result;
        document.getElementById('cropModal').classList.remove('hidden');

        if (cropper) { cropper.destroy(); cropper = null; }

        img.onload = function() {
            cropper = new Cropper(img, {
                aspectRatio: parseAspectRatio(document.getElementById('aspectRatio').value),
                viewMode: 2,
                autoCropArea: 0.9,
                background: false,
            });
        };
    };
    reader.readAsDataURL(file);
});

document.getElementById('aspectRatio').addEventListener('change', function() {
    if (cropper) cropper.setAspectRatio(parseAspectRatio(this.value));
});

document.getElementById('cancelCrop').addEventListener('click', function() {
    document.getElementById('cropModal').classList.add('hidden');
    document.getElementById('fotoInput').value = '';
    if (cropper) { cropper.destroy(); cropper = null; }
});

document.getElementById('confirmCrop').addEventListener('click', function() {
    if (!cropper) return;

    cropper.getCroppedCanvas({ maxWidth: 1024, maxHeight: 1024 }).toBlob(function(blob) {
        const dt = new DataTransfer();
        dt.items.add(new File([blob], 'cropped.jpg', { type: 'image/jpeg' }));
        document.getElementById('fotoInput').files = dt.files;

        document.getElementById('preview').src = URL.createObjectURL(blob);
        document.getElementById('previewContainer').classList.remove('hidden');
        document.getElementById('cropModal').classList.add('hidden');
        if (cropper) { cropper.destroy(); cropper = null; }
    }, 'image/jpeg', 0.9);
});

function parseAspectRatio(val) {
    if (val === 'NaN') return NaN;
    var parts = val.split('/');
    return parts[0] / parts[1];
}
</script>
