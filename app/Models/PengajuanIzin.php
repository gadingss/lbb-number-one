<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    protected $fillable = [
        'jadwal_id',
        'pengaju_id',
        'tipe_pengaju',
        'tanggal_izin',
        'alasan',
        'status',
        'usulan_hari',
        'usulan_jam_mulai',
        'usulan_jam_selesai',
        'usulan_tanggal',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }

    public function jadwalPengganti()
    {
        return $this->hasOne(JadwalPengganti::class);
    }
}
