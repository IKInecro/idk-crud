<?php

namespace App\Providers;

use App\Models\Mahasiswa;
use App\Policies\MahasiswaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Mahasiswa::class, MahasiswaPolicy::class);
    }
}
