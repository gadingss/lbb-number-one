<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    // ===============================
    // INDEX - Riwayat Les
    // ===============================
    public function index()
    {
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $riwayats = Absensi::with(['jadwal.mataPelajaran', 'tutor.user'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.riwayat.index', compact('riwayats'));
    }

    // ===============================
    // KONFIRMASI - Siswa Konfirmasi
    // ===============================
    public function konfirmasi(Request $request, Absensi $absensi)
    {
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Pastikan absensi milik siswa ini
        if ($absensi->siswa_id !== $siswa->id) {
            return redirect()->route('siswa.riwayat.index')
                ->with('error', 'Tidak berhak melakukan konfirmasi');
        }

        $request->validate([
            'konfirmasi_siswa' => 'required|in:hadir,tidak_hadir',
        ]);

        $absensi->update([
            'konfirmasi_siswa' => $request->konfirmasi_siswa,
        ]);

        return redirect()->route('siswa.riwayat.index')
            ->with('success', 'Berhasil melakukan konfirmasi kehadiran.');
    }
}
