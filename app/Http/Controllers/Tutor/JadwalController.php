<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Tutor;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $tutor = Tutor::where('user_id', $user->id)->first();
        
        if (!$tutor) {
            return redirect()->route('tutor.dashboard')->with('error', 'Data tutor tidak ditemukan');
        }

        $jadwals = Jadwal::with(['siswa.user', 'mataPelajaran'])
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->get();

        $pengajuanIzins = \App\Models\PengajuanIzin::with(['jadwal.mataPelajaran', 'jadwal.siswa.user', 'pengaju'])
            ->whereHas('jadwal', function($q) use ($tutor) {
                $q->where('tutor_id', $tutor->id);
            })->latest()->get();

        $jadwalPenggantis = \App\Models\JadwalPengganti::with(['jadwal.mataPelajaran', 'jadwal.siswa.user'])
            ->whereHas('jadwal', function($q) use ($tutor) {
                $q->where('tutor_id', $tutor->id);
            })->latest()->get();

        return view('tutor.jadwal.index', compact('jadwals', 'pengajuanIzins', 'jadwalPenggantis'));
    }
}
