<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Tutor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // ===============================
    // DASHBOARD TUTOR
    // ===============================
    public function index()
    {
        $user = auth()->user();
        $tutor = Tutor::where('user_id', $user->id)->first();
        
        // Jika data tutor tidak ada, redirect ke login
        if (!$tutor) {
            return redirect()->route('login')->with('error', 'Data tutor tidak ditemukan');
        }

        // Jadwal hari ini
        $hariIni = date('l');
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hari = $hariIndonesia[$hariIni] ?? $hariIni;

        $jadwalHariIni = Jadwal::with(['mataPelajaran'])
            ->where('tutor_id', $tutor->id)
            ->where('hari', $hari)
            ->get();

        // Semua jadwal
        $semuaJadwal = Jadwal::with(['mataPelajaran'])
            ->where('tutor_id', $tutor->id)
            ->get();

        // Riwayat absensi tutor
        $riwayatAbsensi = Absensi::with(['jadwal.mataPelajaran', 'siswa.user'])
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->limit(10)
            ->get();

        // Statistik
        $totalPertemuan = Absensi::where('tutor_id', $tutor->id)->count();
        $pertemuanBulanIni = Absensi::where('tutor_id', $tutor->id)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->count();

        return view('tutor.dashboard', compact(
            'tutor',
            'jadwalHariIni',
            'semuaJadwal',
            'riwayatAbsensi',
            'totalPertemuan',
            'pertemuanBulanIni'
        ));
    }
}
