<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutor extends Model
{
    use HasFactory;

    // # Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'no_hp',
        'alamat',
        'mata_pelajaran_id',
        'pendidikan_terakhir',
        'kuota_siswa',
        'latitude',
        'longitude',
    ];

    // # Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // # Relasi ke tabel mata_pelajarans
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    // # Relasi ke tabel jadwals
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function getActiveStudentsCountAttribute()
    {
        $siswaIds = $this->jadwals()->whereNotNull('siswa_id')->distinct()->pluck('siswa_id');
        
        $activeCount = 0;
        foreach($siswaIds as $siswaId) {
            $siswa = Siswa::find($siswaId);
            if ($siswa && $siswa->is_active) {
                $activeCount++;
            }
        }
        return $activeCount;
    }
}