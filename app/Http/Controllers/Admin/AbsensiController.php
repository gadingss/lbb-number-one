<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // ===============================
    // INDEX - Daftar Absensi
    // ===============================
    public function index(Request $request)
    {
        $query = Absensi::with(['jadwal.mataPelajaran', 'siswa.user', 'tutor.user']);

        // Filter by tutor
        if ($request->tutor_id) {
            $query->where('tutor_id', $request->tutor_id);
        }

        // Filter by mata pelajaran
        if ($request->mata_pelajaran_id) {
            $query->whereHas('jadwal', function ($q) use ($request) {
                $q->where('mata_pelajaran_id', $request->mata_pelajaran_id);
            });
        }

        // Filter by date range
        if ($request->rentang) {
            $now = Carbon::now();
            switch ($request->rentang) {
                case '7':
                    $query->where('tanggal', '>=', $now->subDays(7));
                    break;
                case '30':
                    $query->where('tanggal', '>=', $now->subDays(30));
                    break;
                case 'bulan_ini':
                    $query->whereMonth('tanggal', Carbon::now()->month)
                          ->whereYear('tanggal', Carbon::now()->year);
                    break;
            }
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Paginate for the table
        $absensis = $query->latest('tanggal')->paginate(15)->appends($request->query());

        // Statistics - compute from ALL records (unfiltered) for the metric cards
        $allAbsensi = Absensi::all();
        $totalAbsensi = $allAbsensi->count();
        $totalHadir = $allAbsensi->where('status', 'hadir')->count();
        $totalAlpha = $allAbsensi->where('status', 'alpha')->count();
        $totalIzin = $allAbsensi->where('status', 'izin')->count();
        $totalTidakHadir = $allAbsensi->where('status', 'tidak_hadir')->count();

        $persentaseKehadiran = $totalAbsensi > 0
            ? round(($totalHadir / $totalAbsensi) * 100, 1)
            : 0;

        // Count active sessions this week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $sesiAktifMingguIni = Absensi::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->count();

        // Count alerts: alpha records that need attention
        $peringatan = $totalAlpha + $totalTidakHadir;

        // Subject distribution for chart
        $mataPelajarans = MataPelajaran::withCount(['jadwals' => function ($q) {
            $q->whereHas('siswa'); // only jadwals with siswa assigned
        }])->get();

        $totalJadwal = $mataPelajarans->sum('jadwals_count');
        $distribusiMapel = $mataPelajarans->map(function ($mapel) use ($totalJadwal) {
            return [
                'nama' => $mapel->nama_mapel,
                'jumlah' => $mapel->jadwals_count,
                'persentase' => $totalJadwal > 0 ? round(($mapel->jadwals_count / $totalJadwal) * 100, 0) : 0,
            ];
        })->sortByDesc('persentase')->values();

        // Data for filters
        $tutors = Tutor::with('user')->get();
        $mapelList = MataPelajaran::all();
        $jumlahMapel = $mapelList->count();

        return view('admin.absensi.index', compact(
            'absensis',
            'tutors',
            'mapelList',
            'persentaseKehadiran',
            'sesiAktifMingguIni',
            'peringatan',
            'jumlahMapel',
            'distribusiMapel',
            'totalHadir',
            'totalAbsensi',
            'totalAlpha',
            'totalIzin',
            'totalTidakHadir'
        ));
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
    // DESTROY - Hapus Absensi
    // ===============================
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus');
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
