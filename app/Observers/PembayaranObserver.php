<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;

class PembayaranObserver
{
    /**
     * Handle the Pembayaran "updated" event.
     */
    public function updated(Pembayaran $pembayaran): void
    {
        // Cek jika status berubah menjadi 'lunas'
        if ($pembayaran->isDirty('status') && $pembayaran->status === 'lunas') {
            
            // Pastikan relasi siswa ada dan memiliki nomor HP
            if ($pembayaran->siswa && $pembayaran->siswa->no_hp) {
                
                $namaSiswa = $pembayaran->siswa->user->name ?? 'Siswa';
                $namaPaket = $pembayaran->paket->nama_paket ?? 'Paket Belajar';
                $jumlahFormat = 'Rp' . number_format($pembayaran->jumlah, 0, ',', '.');
                $invoice = 'INV-' . str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT);

                $message = "🎉 *PEMBAYARAN BERHASIL*\n\n"
                         . "Halo {$namaSiswa},\n"
                         . "Terima kasih, pembayaran Anda untuk *{$namaPaket}* sebesar *{$jumlahFormat}* telah berhasil kami konfirmasi dan dinyatakan *LUNAS*.\n\n"
                         . "Nomor Invoice: {$invoice}\n"
                         . "Metode: " . strtoupper($pembayaran->metode_pembayaran) . "\n\n"
                         . "Selamat belajar dan terus semangat! 📚✨\n"
                         . "- *LBB Number One*";

                $fonnte = app(FonnteService::class);
                $fonnte->sendMessage($pembayaran->siswa->no_hp, $message);
                
                Log::info("Fonnte Notification Sent: Pembayaran Lunas untuk Siswa ID {$pembayaran->siswa->id}");
            }
        }
    }
}
