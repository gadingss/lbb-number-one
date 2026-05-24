<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Paket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // ===============================
    // DASHBOARD SISWA
    // ===============================
    public function index()
    {
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        
        // Jika data siswa tidak ada, redirect ke login
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }

        // Cari semua paket aktif (lunas dan sesinya belum habis)
        $pembayarans = Pembayaran::where('siswa_id', $siswa->id)
            ->where('status', 'lunas')
            ->with('paket.mataPelajaran')
            ->orderByDesc('id')
            ->get();
            
        $paketAktifList = [];
        
        foreach ($pembayarans as $pembayaran) {
            if ($pembayaran->paket) {
                // Hitung absensi spesifik untuk paket (pembayaran) ini
                $sesiTerpakai = Absensi::whereHas('jadwal', function($q) use ($pembayaran) {
                    $q->where('pembayaran_id', $pembayaran->id);
                })->where('status', 'hadir')->count();

                if ($sesiTerpakai < $pembayaran->paket->jumlah_pertemuan) {
                    $pembayaran->sesi_terpakai = $sesiTerpakai;
                    $pembayaran->sisa_sesi = $pembayaran->paket->jumlah_pertemuan - $sesiTerpakai;
                    $paketAktifList[] = $pembayaran;
                }
            }
        }

        // Riwayat pembayaran
        $riwayatPembayaran = Pembayaran::where('siswa_id', $siswa->id)
            ->with('paket')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Riwayat les/absensi
        $riwayatLes = Absensi::where('siswa_id', $siswa->id)
            ->with(['jadwal.mataPelajaran', 'tutor.user'])
            ->latest()
            ->limit(10)
            ->get();

        // Statistik
        $totalPertemuan = Absensi::where('siswa_id', $siswa->id)->count();
        $pertemuanBulanIni = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->count();

        $totalPembayaran = Pembayaran::where('siswa_id', $siswa->id)
            ->where('status', 'lunas')
            ->sum('jumlah');

        // Jadwal Terdekat
        $jadwalTerdekat = \App\Models\Jadwal::where('siswa_id', $siswa->id)
            ->with(['mataPelajaran', 'tutor.user'])
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'paketAktifList',
            'riwayatPembayaran',
            'riwayatLes',
            'totalPertemuan',
            'pertemuanBulanIni',
            'totalPembayaran',
            'jadwalTerdekat'
        ));
    }
}
