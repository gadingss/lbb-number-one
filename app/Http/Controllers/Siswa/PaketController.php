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
        
        // Ambil paket yang sudah dibeli (lunas) dan cek mana saja yang belum habis
        $paketAktif = null;
        $activePaketIds = [];

        if ($siswa) {
            $pembayarans = Pembayaran::where('siswa_id', $siswa->id)
                ->where('status', 'lunas')
                ->with('paket')
                ->get();
                
            foreach ($pembayarans as $pembayaran) {
                // Hitung pertemuan yang sudah terlaksana untuk paket ini
                $absensiCount = \App\Models\Absensi::whereHas('jadwal', function($q) use ($pembayaran) {
                    $q->where('pembayaran_id', $pembayaran->id);
                })->count();
                
                if ($pembayaran->paket && $absensiCount < $pembayaran->paket->jumlah_pertemuan) {
                    // Paket ini masih aktif (belum habis)
                    $activePaketIds[] = $pembayaran->paket_id;
                    $paketAktif = $pembayaran; // Simpan salah satu untuk banner
                }
            }
        }

        // Cari paket paling populer berdasarkan jumlah pembayaran lunas
        $popularPaketId = \App\Models\Pembayaran::where('status', 'lunas')
            ->select('paket_id')
            ->groupBy('paket_id')
            ->orderByRaw('COUNT(*) DESC')
            ->value('paket_id');
            
        // Jika belum ada data pembayaran, jadikan paket kedua (jika ada) sebagai default populer
        if (!$popularPaketId && $pakets->count() > 0) {
            $popularPaketId = $pakets->count() > 1 ? $pakets[1]->id : $pakets[0]->id;
        }

        return view('siswa.paket.index', compact('pakets', 'paketAktif', 'popularPaketId', 'activePaketIds'));
    }

    // ===============================
    // PILIH JADWAL & TUTOR
    // ===============================
    public function pilihJadwal(Paket $paket)
    {
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('siswa.paket.index')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        // Cek apakah paket ini sedang aktif dan belum habis
        $pembayaranAktif = Pembayaran::where('siswa_id', $siswa->id)
            ->where('paket_id', $paket->id)
            ->where('status', 'lunas')
            ->latest()
            ->first();

        if ($pembayaranAktif) {
            $absensiCount = \App\Models\Absensi::whereHas('jadwal', function($q) use ($pembayaranAktif) {
                $q->where('pembayaran_id', $pembayaranAktif->id);
            })->count();

            if ($absensiCount < $paket->jumlah_pertemuan) {
                return redirect()->route('siswa.paket.index')
                    ->with('error', 'Anda tidak dapat memilih paket ini lagi karena paket sebelumnya belum habis.');
            }
        }

        // Batasan jadwal yang bisa dipilih dalam seminggu.
        // Dibatasi maksimal 5 slot per minggu sesuai request admin
        $kuotaJadwal = min($paket->jumlah_pertemuan, 5);

        $tutors = \App\Models\Tutor::where('mata_pelajaran_id', $paket->mata_pelajaran_id)->with('user')->get();

        $jadwalSiswa = \App\Models\Jadwal::where('siswa_id', $siswa->id)
            ->whereIn('status', ['aktif', 'pending', 'reschedule'])
            ->get(['hari', 'jam_mulai', 'jam_selesai']);

        return view('siswa.paket.pilih_jadwal', compact('paket', 'tutors', 'kuotaJadwal', 'jadwalSiswa'));
    }

    // ===============================
    // AJAX: Get Tutor Schedules
    // ===============================
    public function getTutorSchedules($tutor_id)
    {
        $jadwals = \App\Models\Jadwal::withoutGlobalScope('exclude_pending')
            ->where('tutor_id', $tutor_id)
            ->whereIn('status', ['aktif', 'reschedule', 'pending'])
            ->get(['hari', 'jam_mulai', 'jam_selesai']);

        return response()->json($jadwals);
    }

    // ===============================
    // PEMESANAN - Pilih Paket (Dengan Midtrans)
    // ===============================
    public function pesan(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'tutor_id' => 'required|exists:tutors,id',
            'jadwals' => 'required|array',
            'jadwals.*' => 'string' // Format: "Senin|15:00-17:00"
        ]);

        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('siswa.paket.index')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        $paket = Paket::findOrFail($request->paket_id);

        // Cek apakah paket ini sedang aktif dan belum habis
        $pembayaranAktif = Pembayaran::where('siswa_id', $siswa->id)
            ->where('paket_id', $paket->id)
            ->where('status', 'lunas')
            ->latest()
            ->first();

        if ($pembayaranAktif) {
            $absensiCount = \App\Models\Absensi::whereHas('jadwal', function($q) use ($pembayaranAktif) {
                $q->where('pembayaran_id', $pembayaranAktif->id);
            })->count();

            if ($absensiCount < $paket->jumlah_pertemuan) {
                return redirect()->route('siswa.paket.index')
                    ->with('error', 'Anda masih memiliki paket ini yang belum habis sesinya.');
            }
        }
        
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

        // Buat record jadwal untuk setiap slot yang dipilih
        foreach ($request->jadwals as $slot) {
            $parts = explode('|', $slot);
            if (count($parts) === 2) {
                $hari = $parts[0];
                $waktu = explode('-', $parts[1]);
                if (count($waktu) === 2) {
                    $jam_mulai = $waktu[0] . ':00';
                    $jam_selesai = $waktu[1] . ':00';
                    
                    // Cek bentrok jadwal Siswa
                    $bentrokSiswa = \App\Models\Jadwal::where('siswa_id', $siswa->id)
                        ->where('hari', $hari)
                        ->whereIn('status', ['aktif', 'pending', 'reschedule'])
                        ->where(function($query) use ($jam_mulai, $jam_selesai) {
                            $query->where(function($q) use ($jam_mulai, $jam_selesai) {
                                $q->where('jam_mulai', '<', $jam_selesai)
                                  ->where('jam_selesai', '>', $jam_mulai);
                            });
                        })->exists();

                    if ($bentrokSiswa) {
                        return redirect()->back()
                            ->with('error', "Maaf, Jadwal Anda bentrok pada hari $hari jam $jam_mulai - $jam_selesai dengan kelas Anda yang lain.");
                    }

                    \App\Models\Jadwal::create([
                        'tutor_id' => $request->tutor_id,
                        'siswa_id' => $siswa->id,
                        'pembayaran_id' => $pembayaran->id,
                        'mata_pelajaran_id' => $paket->mata_pelajaran_id,
                        'hari' => $hari,
                        'jam_mulai' => $jam_mulai,
                        'jam_selesai' => $jam_selesai,
                        'status' => 'pending',
                    ]);
                }
            }
        }

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
