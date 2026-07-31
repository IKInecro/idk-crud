<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Marco',
            'email' => 'admin@mncu.univ.ac.id',
            'password' => bcrypt('jawa1234'),
            'role' => 'admin',
        ]);

        $this->call(MahasiswaSeeder::class);
    }
}
