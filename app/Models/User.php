<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tutor;
use App\Models\Siswa;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'kode',
        'name',
        'email',
        'password',
        'role',
        'is_verified',
    ];

    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===============================
    // # Relasi ke Tutor
    // ===============================
    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    // ===============================
    // # Relasi ke Siswa
    // ===============================
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
}
