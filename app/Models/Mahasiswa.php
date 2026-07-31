<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'email',
        'jurusan',
        'angkatan',
        'tgl_lahir',
        'alamat',
        'foto',
        'created_by',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
            'alamat' => 'encrypted',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
