<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Tutor;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // ===============================
    // INDEX - Daftar Absensi
    // ===============================
    public function index()
    {
        $user = auth()->user();
        $tutor = Tutor::where('user_id', $user->id)->first();

        $absensis = Absensi::with(['jadwal.mataPelajaran', 'siswa.user'])
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->get();

        return view('tutor.absensi.index', compact('absensis'));
    }

    // ===============================
    // CREATE - Form Catat Absensi
    // ===============================
    public function create(Request $request)
    {
        $user = auth()->user();
        $tutor = Tutor::where('user_id', $user->id)->first();

        $jadwals = Jadwal::with(['mataPelajaran', 'siswa.user'])
            ->where('tutor_id', $tutor->id)
            ->get();

        $jadwalPenggantis = \App\Models\JadwalPengganti::with(['jadwal.mataPelajaran', 'jadwal.siswa.user'])
            ->whereHas('jadwal', function($q) use ($tutor) {
                $q->where('tutor_id', $tutor->id);
            })
            ->where('status', 'menunggu_dilaksanakan')
            ->get();

        $selectedJadwal = $request->query('jadwal', '');

        return view('tutor.absensi.create', compact('jadwals', 'jadwalPenggantis', 'selectedJadwal'));
    }

    // ===============================
    // STORE - Simpan Absensi
    // ===============================
    public function store(Request $request)
    {
        $user = auth()->user();
        $tutor = Tutor::where('user_id', $user->id)->first();

        $request->validate([
            'jadwal_id' => 'required',
            'tanggal' => 'required|date',
            'jam_absen' => 'required|date_format:H:i',
            'status' => 'required|in:hadir,tidak_hadir,izin,alpha',
            'catatan' => 'nullable|string',
            'hasil_pertemuan' => 'nullable|string',
        ]);

        $parts = explode('_', $request->jadwal_id);
        $type = $parts[0]; // rutin atau pengganti
        $id = $parts[1];

        if ($type === 'pengganti') {
            $jp = \App\Models\JadwalPengganti::findOrFail($id);
            $jadwalId = $jp->jadwal_id;
            // Tandai jadwal pengganti sudah selesai dilaksanakan
            $jp->update(['status' => 'selesai']);
        } else {
            $jadwalId = $id;
        }

        $jadwal = Jadwal::findOrFail($jadwalId);

        Absensi::create([
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $jadwal->siswa_id,
            'tutor_id' => $tutor->id,
            'tanggal' => $request->tanggal,
            'jam_absen' => $request->jam_absen,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'hasil_pertemuan' => $request->hasil_pertemuan,
        ]);

        return redirect()->route('tutor.absensi.index')
            ->with('success', 'Absensi berhasil dicatat');
    }

    // ===============================
    // RIWAYAT - Riwayat Mengajar
    // ===============================
    public function riwayat()
    {
        $user = auth()->user();
        $tutor = Tutor::where('user_id', $user->id)->first();

        $absensis = Absensi::with(['jadwal.mataPelajaran', 'siswa.user'])
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->get();

        return view('tutor.riwayat.index', compact('absensis'));
    }
}
