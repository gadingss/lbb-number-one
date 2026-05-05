<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // ===============================
    // INDEX - Daftar Paket
    // ===============================
    public function index()
    {
        $pakets = Paket::with('mataPelajaran')->get();
        
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        
        // Ambil paket yang sudah dibeli (lunas)
        $paketAktif = null;
        if ($siswa) {
            $paketAktif = Pembayaran::where('siswa_id', $siswa->id)
                ->where('status', 'lunas')
                ->with('paket')
                ->latest()
                ->first();
        }

        return view('siswa.paket.index', compact('pakets', 'paketAktif'));
    }

    // ===============================
    // PEMESANAN - Pilih Paket (Dengan Midtrans)
    // ===============================
    public function pesan(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
        ]);

        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('siswa.paket.index')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        $paket = Paket::findOrFail($request->paket_id);
        
        // Buat Order ID Unik
        $orderId = 'LBB-' . time() . '-' . $siswa->id;

        // Buat record pembayaran (status pending)
        $pembayaran = Pembayaran::create([
            'order_id' => $orderId,
            'siswa_id' => $siswa->id,
            'paket_id' => $paket->id,
            'tanggal_bayar' => now(),
            'jumlah' => $paket->harga,
            'status' => 'pending',
            'metode_pembayaran' => 'Midtrans',
            'keterangan' => 'Pemesanan paket ' . $paket->nama_paket,
        ]);

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = config('midtrans.isProduction', env('MIDTRANS_IS_PRODUCTION', false));
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized', env('MIDTRANS_IS_SANITIZED', true));
        \Midtrans\Config::$is3ds = config('midtrans.is3ds', env('MIDTRANS_IS_3DS', true));

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $paket->harga,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $siswa->no_hp ?? '',
            ],
            'item_details' => [
                [
                    'id' => $paket->id,
                    'price' => (int) $paket->harga,
                    'quantity' => 1,
                    'name' => $paket->nama_paket,
                ]
            ],
            'enabled_payments' => [
                'bca_va',
                'bni_va',
                'bri_va',
                'permata_va',
                'mandiri_bill',
                'gopay',
                'qris',
                'shopeepay',
                'indomaret',
                'alfamart',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Simpan snap token ke database
            $pembayaran->update(['snap_token' => $snapToken]);
            
            return view('siswa.paket.bayar', compact('pembayaran', 'snapToken', 'paket'));
        } catch (\Exception $e) {
            return redirect()->route('siswa.paket.index')
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}
