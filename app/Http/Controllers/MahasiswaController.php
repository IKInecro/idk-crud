<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public static function fakultasList(): array
    {
        return [
            'Fakultas Bisnis dan Keuangan' => ['Manajemen', 'Akuntansi', 'Pendidikan Matematika'],
            'Fakultas Industri Kreatif' => ['Pendidikan Bahasa Inggris', 'Sains Komunikasi', 'Desain Komunikasi Visual', 'Sistem Informasi', 'Ilmu Komputer'],
        ];
    }

    public function index(Request $request)
    {
        $query = Mahasiswa::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nim', 'like', "%{$s}%")
                  ->orWhere('nama', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('jurusan', 'like', "%{$s}%")
                  ->orWhere('angkatan', 'like', "%{$s}%");
            });
        }

        if ($request->filled('fakultas') && array_key_exists($request->fakultas, static::fakultasList())) {
            $query->whereIn('jurusan', static::fakultasList()[$request->fakultas]);
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        $mahasiswas = $query->paginate(10)->withQueryString();
        $jurusanList = Mahasiswa::distinct()->pluck('jurusan')->sort();
        $angkatanList = Mahasiswa::distinct()->pluck('angkatan')->sort();

        if ($request->has('_live')) {
            return view('mahasiswa._table', compact('mahasiswas'));
        }

        return view('mahasiswa.index', compact('mahasiswas', 'jurusanList', 'angkatanList'));
    }

    public function create()
    {
        $this->authorize('create', Mahasiswa::class);
        return view('mahasiswa.create');
    }

    public function store(StoreMahasiswaRequest $request)
    {
        $this->authorize('create', Mahasiswa::class);
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $this->authorize('view', $mahasiswa);
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $this->authorize('update', $mahasiswa);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $this->authorize('update', $mahasiswa);

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $this->authorize('delete', $mahasiswa);

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
