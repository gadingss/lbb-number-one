<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Tutor;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
    public function index()
    {
        $jadwals = Jadwal::with(['tutor.user', 'mataPelajaran', 'siswa.user'])
            ->latest()
            ->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $tutors = Tutor::with('user')->get();
        $mapels = MataPelajaran::all();
        $siswas = Siswa::with('user')->get();

        return view('admin.jadwal.create', compact('tutors', 'mapels', 'siswas'));
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Jadwal::create([
            'tutor_id' => $request->tutor_id,
            'siswa_id' => $request->siswa_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit(Jadwal $jadwal)
    {
        $tutors = Tutor::with('user')->get();
        $mapels = MataPelajaran::all();
        $siswas = Siswa::with('user')->get();

        return view('admin.jadwal.edit', compact('jadwal', 'tutors', 'mapels', 'siswas'));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $jadwal->update([
            'tutor_id' => $request->tutor_id,
            'siswa_id' => $request->siswa_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    // ===============================
    // DESTROY
    // ===============================
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}