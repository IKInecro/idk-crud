<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mahasiswaId = $this->route('mahasiswa');

        return [
            'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswas', 'nim')->ignore($mahasiswaId)],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'size:1', 'in:L,P'],
            'email' => ['required', 'email', 'max:255', Rule::unique('mahasiswas', 'email')->ignore($mahasiswaId)],
            'jurusan' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
            'tgl_lahir' => ['required', 'date', 'before:today'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'angkatan.required' => 'Angkatan wajib diisi.',
            'angkatan.size' => 'Angkatan harus 4 digit.',
            'angkatan.regex' => 'Angkatan hanya boleh angka.',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpg atau png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
