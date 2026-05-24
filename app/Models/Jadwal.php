<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'tutor_id',
        'siswa_id',
        'pembayaran_id',
        'mata_pelajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected static function booted()
    {
        // Secara default, jadwal yang masih berstatus 'pending' (belum dibayar lunas) tidak akan ditampilkan
        static::addGlobalScope('exclude_pending', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('jadwals.status', '!=', 'pending');
        });
    }

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
    
    // Relasi ke Pembayaran
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
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