<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // ===============================
    // INDEX - Jadwal Les Siswa
    // ===============================
    public function index()
    {
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Ambil jadwal khusus untuk siswa ini
        $jadwals = Jadwal::with(['tutor.user', 'mataPelajaran'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        $pengajuanIzins = \App\Models\PengajuanIzin::with(['jadwal.mataPelajaran', 'jadwal.tutor.user', 'pengaju'])
            ->whereHas('jadwal', function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            })->latest()->get();

        $jadwalPenggantis = \App\Models\JadwalPengganti::with(['jadwal.mataPelajaran', 'jadwal.tutor.user'])
            ->whereHas('jadwal', function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            })->latest()->get();

        return view('siswa.jadwal.index', compact('jadwals', 'pengajuanIzins', 'jadwalPenggantis'));
    }
}
