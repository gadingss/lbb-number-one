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

        // Paket yang dimiliki (menampilkan paket yang terakhir kali dibeli)
        $paket = Pembayaran::where('siswa_id', $siswa->id)
            ->where('status', 'lunas')
            ->with('paket')
            ->latest()
            ->first();

        // Ambil semua paket yang sudah lunas untuk menghitung akumulasi total sesi
        $semuaPaket = Pembayaran::where('siswa_id', $siswa->id)
            ->where('status', 'lunas')
            ->with('paket')
            ->get();
            
        $totalKuotaSesi = $semuaPaket->sum(function($p) {
            return $p->paket ? $p->paket->jumlah_pertemuan : 0;
        });

        // Hitung total sesi terpakai (all-time kehadiran)
        $sesiTerpakai = Absensi::where('siswa_id', $siswa->id)
            ->where('status', 'hadir')
            ->count();
            
        // Sisa sesi adalah akumulasi dari semua paket dikurangi total kehadiran
        $sisaSesi = max(0, $totalKuotaSesi - $sesiTerpakai);

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
            'paket',
            'riwayatPembayaran',
            'riwayatLes',
            'totalPertemuan',
            'pertemuanBulanIni',
            'totalPembayaran',
            'sesiTerpakai',
            'sisaSesi',
            'jadwalTerdekat'
        ));
    }
}
