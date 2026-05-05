<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPengganti extends Model
{
    protected $fillable = [
        'pengajuan_izin_id',
        'jadwal_id',
        'tanggal_pengganti',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function pengajuanIzin()
    {
        return $this->belongsTo(PengajuanIzin::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
