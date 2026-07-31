<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@mncu.univ.ac.id')->first();

        $data = [
            ['nim' => '220101001', 'nama' => 'Ahmad Fauzi', 'email' => 'ahmad@mncu.univ.ac.id', 'jurusan' => 'Teknik Informatika', 'angkatan' => '2022', 'tgl_lahir' => '2004-05-12', 'created_by' => $admin->id],
            ['nim' => '220101002', 'nama' => 'Siti Nurhaliza', 'email' => 'siti@mncu.univ.ac.id', 'jurusan' => 'Sistem Informasi', 'angkatan' => '2022', 'tgl_lahir' => '2004-08-21', 'created_by' => $admin->id],
            ['nim' => '220101003', 'nama' => 'Budi Santoso', 'email' => 'budi.s@mncu.univ.ac.id', 'jurusan' => 'Teknik Informatika', 'angkatan' => '2022', 'tgl_lahir' => '2003-12-03', 'created_by' => $admin->id],
            ['nim' => '220101004', 'nama' => 'Dewi Lestari', 'email' => 'dewi@mncu.univ.ac.id', 'jurusan' => 'Manajemen Informatika', 'angkatan' => '2022', 'tgl_lahir' => '2004-01-18', 'created_by' => $admin->id],
            ['nim' => '220101005', 'nama' => 'Rizky Pratama', 'email' => 'rizky@mncu.univ.ac.id', 'jurusan' => 'Teknik Komputer', 'angkatan' => '2022', 'tgl_lahir' => '2004-07-22', 'created_by' => $admin->id],
        ];

        foreach ($data as $item) {
            Mahasiswa::create($item);
        }
    }
}
