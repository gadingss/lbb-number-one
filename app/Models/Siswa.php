<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Siswa extends Model
{
    protected $fillable = [
        'user_id',
        'no_hp',
        'alamat',
        'kelas',
        'sekolah',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsActiveAttribute()
    {
        $paket = Pembayaran::where('siswa_id', $this->id)
            ->where('status', 'lunas')
            ->with('paket')
            ->latest()
            ->first();

        if (!$paket || !$paket->paket) {
            return false;
        }

        $sesiTerpakai = Absensi::where('siswa_id', $this->id)
            ->where('created_at', '>=', $paket->created_at)
            ->where('status', 'hadir')
            ->count();
        
        $sisaSesi = max(0, $paket->paket->jumlah_pertemuan - $sesiTerpakai);
        return $sisaSesi > 0;
    }
}
