<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $fillable = [
        'jadwal_id',
        'siswa_id',
        'tutor_id',
        'tanggal',
        'jam_absen',
        'status',
        'konfirmasi_siswa',
        'catatan',
        'hasil_pertemuan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jam_absen' => 'datetime:H:i',
        ];
    }

    // Relasi ke Jadwal
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    // Relasi ke Siswa
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Tutor
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
