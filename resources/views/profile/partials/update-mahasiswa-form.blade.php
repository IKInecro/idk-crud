@php $mhs = auth()->user()->mahasiswa; @endphp

<form method="POST" action="{{ route('profile.mahasiswa.update') }}" enctype="multipart/form-data" id="mahasiswaForm">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim', $mhs?->nim)" required maxlength="20" placeholder="Contoh: 220102001" />
            <p class="text-xs mt-1 text-gray-400">NIM tanpa spasi</p>
            <x-input-error :messages="$errors->get('nim')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <div class="flex gap-4 mt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="jenis_kelamin" value="L" @checked(old('jenis_kelamin', $mhs?->jenis_kelamin) == 'L') required class="text-[#0c1e3f] focus:ring-blue-300">
                    <span class="text-sm text-gray-700">Laki-laki</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="jenis_kelamin" value="P" @checked(old('jenis_kelamin', $mhs?->jenis_kelamin) == 'P') required class="text-[#0c1e3f] focus:ring-blue-300">
                    <span class="text-sm text-gray-700">Perempuan</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="jurusan" :value="__('Jurusan')" />
            <select id="jurusan" name="jurusan" class="border-gray-300 focus:border-gray-900 focus:ring-blue-300 rounded-xl shadow-sm w-full mt-1" required>
                <option value="">Pilih Jurusan</option>
                <optgroup label="Fakultas Bisnis dan Keuangan">
                    <option value="Manajemen" @selected(old('jurusan', $mhs?->jurusan) == 'Manajemen')>Manajemen</option>
                    <option value="Akuntansi" @selected(old('jurusan', $mhs?->jurusan) == 'Akuntansi')>Akuntansi</option>
                    <option value="Pendidikan Matematika" @selected(old('jurusan', $mhs?->jurusan) == 'Pendidikan Matematika')>Pendidikan Matematika</option>
                </optgroup>
                <optgroup label="Fakultas Industri Kreatif">
                    <option value="Pendidikan Bahasa Inggris" @selected(old('jurusan', $mhs?->jurusan) == 'Pendidikan Bahasa Inggris')>Pendidikan Bahasa Inggris</option>
                    <option value="Sains Komunikasi" @selected(old('jurusan', $mhs?->jurusan) == 'Sains Komunikasi')>Sains Komunikasi</option>
                    <option value="Desain Komunikasi Visual" @selected(old('jurusan', $mhs?->jurusan) == 'Desain Komunikasi Visual')>Desain Komunikasi Visual</option>
                    <option value="Sistem Informasi" @selected(old('jurusan', $mhs?->jurusan) == 'Sistem Informasi')>Sistem Informasi</option>
                    <option value="Ilmu Komputer" @selected(old('jurusan', $mhs?->jurusan) == 'Ilmu Komputer')>Ilmu Komputer</option>
                </optgroup>
            </select>
            <x-input-error :messages="$errors->get('jurusan')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="angkatan" :value="__('Angkatan')" />
            <x-text-input id="angkatan" class="block mt-1 w-full" type="text" name="angkatan" :value="old('angkatan', $mhs?->angkatan)" placeholder="Contoh: 2022" required />
            <p class="text-xs mt-1 text-gray-400">4 digit tahun masuk</p>
            <x-input-error :messages="$errors->get('angkatan')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir', $mhs?->tgl_lahir?->format('Y-m-d'))" required />
            <x-input-error :messages="$errors->get('tgl_lahir')" class="mt-1" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea id="alamat" name="alamat" rows="2" placeholder="Alamat lengkap" class="border-gray-300 focus:border-gray-900 focus:ring-blue-300 rounded-xl shadow-sm w-full mt-1">{{ old('alamat', $mhs?->alamat) }}</textarea>
            <x-input-error :messages="$errors->get('alamat')" class="mt-1" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="foto" :value="__('Foto (max 2MB, jpg/png)')" />
            <div class="flex items-start gap-4 mt-1">
                <div>
                    <img src="{{ $mhs?->foto ? Storage::url($mhs->foto) : asset('images/profile default.jpeg') }}"
                         class="h-20 w-20 object-cover rounded-xl border border-gray-200 shadow-sm" alt="Foto">
                </div>
                <div class="flex-1">
                    <input id="fotoInput" type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-800 hover:file:bg-gray-200 file:transition" />
                </div>
            </div>
            <x-input-error :messages="$errors->get('foto')" class="mt-1" />
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
        <button type="submit" style="background:#0c1e3f" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm" onmouseover="this.style.background='#07122e'" onmouseout="this.style.background='#0c1e3f'">
            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Data Mahasiswa
        </button>
    </div>
</form>
