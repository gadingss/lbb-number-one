<?php

namespace App\Http\Controllers\Admin;

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
    public function index(Request $request)
    {
        $query = Absensi::with(['jadwal.mataPelajaran', 'siswa.user', 'tutor.user']);

        // Filter
        if ($request->tutor_id) {
            $query->where('tutor_id', $request->tutor_id);
        }
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest()->get();
        $tutors = Tutor::with('user')->get();

        return view('admin.absensi.index', compact('absensis', 'tutors'));
    }

    // ===============================
    // CREATE - Form Catat Absensi
    // ===============================
    public function create()
    {
        $jadwals = Jadwal::with(['tutor.user', 'mataPelajaran'])->get();
        $tutors = Tutor::with('user')->get();

        return view('admin.absensi.create', compact('jadwals', 'tutors'));
    }

    // ===============================
    // STORE - Simpan Absensi
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'siswa_id' => 'required|exists:siswas,id',
            'tutor_id' => 'required|exists:tutors,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,tidak_hadir,izin,alpha',
            'catatan' => 'nullable|string',
            'hasil_pertemuan' => 'nullable|string',
        ]);

        Absensi::create([
            'jadwal_id' => $request->jadwal_id,
            'siswa_id' => $request->siswa_id,
            'tutor_id' => $request->tutor_id,
            'tanggal' => $request->tanggal,
            'jam_absen' => now()->format('H:i:s'),
            'status' => $request->status,
            'catatan' => $request->catatan,
            'hasil_pertemuan' => $request->hasil_pertemuan,
        ]);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dicatat');
    }

    // ===============================
    // EDIT - Form Edit Absensi
    // ===============================
    public function edit(Absensi $absensi)
    {
        $jadwals = Jadwal::with(['tutor.user', 'mataPelajaran'])->get();

        return view('admin.absensi.edit', compact('absensi', 'jadwals'));
    }

    // ===============================
    // UPDATE - Update Absensi
    // ===============================
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'status' => 'required|in:hadir,tidak_hadir,izin,alpha',
            'catatan' => 'nullable|string',
            'hasil_pertemuan' => 'nullable|string',
        ]);

        $absensi->update($request->all());

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }

    // ===============================
    // REKAP - Rekap Kehadiran Tutor
    // ===============================
    public function rekap(Request $request)
    {
        $query = Absensi::with(['tutor.user']);

        if ($request->tutor_id) {
            $query->where('tutor_id', $request->tutor_id);
        }
        if ($request->bulan) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        $absensis = $query->get();

        // Hitung rekap per tutor
        $rekap = $absensis->groupBy('tutor_id')->map(function ($items) {
            return [
                'total' => $items->count(),
                'hadir' => $items->where('status', 'hadir')->count(),
                'tidak_hadir' => $items->where('status', 'tidak_hadir')->count(),
                'izin' => $items->where('status', 'izin')->count(),
                'alpha' => $items->where('status', 'alpha')->count(),
            ];
        });

        $tutors = Tutor::with('user')->get();

        return view('admin.absensi.rekap', compact('rekap', 'tutors', 'absensis'));
    }
}
