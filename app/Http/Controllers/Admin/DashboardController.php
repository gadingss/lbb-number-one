<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Tutor;
use App\Models\Paket;
use App\Models\MataPelajaran;
use App\Models\Pembayaran;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalTutor = Tutor::count();
        $totalPaket = Paket::count();

        // Penghasilan Bulan Ini
        $monthlyRevenue = Pembayaran::where('status', 'lunas')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah');

        // Tren 6 Bulan (Grafik)
        $paymentTrends = [];
        $maxTotal = 0;
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $total = Pembayaran::where('status', 'lunas')
                ->whereMonth('tanggal_bayar', $date->month)
                ->whereYear('tanggal_bayar', $date->year)
                ->sum('jumlah');
                
            $paymentTrends[] = [
                'month' => $date->format('M'),
                'total' => $total,
            ];
            if ($total > $maxTotal) $maxTotal = $total;
        }

        // Kalkulasi persentase tinggi bar
        foreach ($paymentTrends as &$trend) {
            $trend['percentage'] = $maxTotal > 0 ? max(10, min(100, round(($trend['total'] / $maxTotal) * 100))) : 10;
        }

        // Top 3 Elite Tutors berdasarkan jumlah jadwal terbanyak
        $eliteTutors = Tutor::with('user')
            ->withCount('jadwals')
            ->orderByDesc('jadwals_count')
            ->take(3)
            ->get();

        // Recent Academic Activity (5 last absensi)
        $recentActivities = Absensi::with(['siswa.user', 'jadwal.mataPelajaran', 'tutor.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalTutor',
            'totalPaket',
            'monthlyRevenue',
            'paymentTrends',
            'eliteTutors',
            'recentActivities'
        ));
    }
}