<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'tutor_id',
        'siswa_id',
        'mata_pelajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Relasi ke Tutor
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    // Relasi ke Mata Pelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Pengajuan Izin
    public function pengajuanIzins()
    {
        return $this->hasMany(PengajuanIzin::class);
    }

    // Relasi ke Jadwal Pengganti
    public function jadwalPenggantis()
    {
        return $this->hasMany(JadwalPengganti::class);
    }
}