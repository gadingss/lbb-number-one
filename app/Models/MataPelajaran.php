<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $fillable = [
        'nama_mapel',
        'deskripsi',
    ];

public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function pakets()
    {
        return $this->hasMany(Paket::class);
    }
}
