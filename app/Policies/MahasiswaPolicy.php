<?php

namespace App\Policies;

use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Mahasiswa $mahasiswa): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Mahasiswa $mahasiswa): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Mahasiswa $mahasiswa): bool
    {
        return $user->isAdmin();
    }

}
