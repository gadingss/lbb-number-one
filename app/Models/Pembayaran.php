<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'order_id',
        'siswa_id',
        'paket_id',
        'jumlah',
        'metode_pembayaran',
        'tanggal_bayar',
        'status',
        'bukti_pembayaran',
        'keterangan',
        'snap_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_bayar' => 'date',
            'jumlah' => 'decimal:2',
        ];
    }

    // Relasi ke Siswa
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Paket
    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }
}
