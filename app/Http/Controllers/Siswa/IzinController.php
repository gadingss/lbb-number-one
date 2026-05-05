<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\JadwalPengganti;
use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal_izin' => 'required|date|after_or_equal:today',
            'alasan' => 'required|string',
        ]);

        $jadwal = Jadwal::where('id', $request->jadwal_id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->firstOrFail();

        PengajuanIzin::create([
            'jadwal_id' => $jadwal->id,
            'pengaju_id' => Auth::id(),
            'tipe_pengaju' => 'siswa',
            'tanggal_izin' => $request->tanggal_izin,
            'alasan' => $request->alasan,
            'status' => 'menunggu_lawan',
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim. Menunggu persetujuan dan usulan jadwal pengganti dari Tutor.');
    }

    public function acceptReschedule(Request $request, PengajuanIzin $izin)
    {
        // Pastikan ini izin yang ditujukan untuk siswa ini (sebagai lawan jika tutor yang mengajukan, atau siswa yang mengajukan)
        if ($izin->jadwal->siswa_id != Auth::user()->siswa->id) {
            abort(403);
        }

        if ($izin->status !== 'menunggu_konfirmasi_pengaju') {
            return redirect()->back()->with('error', 'Status izin tidak valid untuk dikonfirmasi.');
        }

        // Jika siswa yang mengonfirmasi, berarti tutor yang mengajukan izin, ATAU siswa yang mengajukan dan tutor sudah mengusulkan
        $izin->update(['status' => 'reschedule_berhasil']);

        JadwalPengganti::create([
            'pengajuan_izin_id' => $izin->id,
            'jadwal_id' => $izin->jadwal_id,
            'tanggal_pengganti' => $izin->usulan_tanggal,
            'jam_mulai' => $izin->usulan_jam_mulai,
            'jam_selesai' => $izin->usulan_jam_selesai,
            'status' => 'menunggu_dilaksanakan',
        ]);

        return redirect()->back()->with('success', 'Jadwal pengganti disetujui. Reschedule berhasil!');
    }

    // Siswa menyetujui izin dari Tutor dan mengusulkan jadwal
    public function approve(Request $request, PengajuanIzin $izin)
    {
        if ($izin->jadwal->siswa_id != Auth::user()->siswa->id) {
            abort(403);
        }

        $request->validate([
            'usulan_tanggal' => 'required|date|after_or_equal:today',
            'usulan_jam_mulai' => 'required|date_format:H:i',
            'usulan_jam_selesai' => 'required|date_format:H:i|after:usulan_jam_mulai',
        ]);

        // PRE-VALIDATED SCHEDULING: Cek bentrok
        $isAvailable = \App\Services\JadwalService::isJadwalAvailable(
            $izin->jadwal->tutor_id,
            $izin->jadwal->siswa_id,
            $request->usulan_tanggal,
            $request->usulan_jam_mulai,
            $request->usulan_jam_selesai
        );

        if (!$isAvailable) {
            return redirect()->back()->with('error', 'Jadwal pengganti yang Anda usulkan BENTROK dengan jadwal aktif (rutin/reschedule) milik Anda atau Tutor. Silakan pilih waktu lain.');
        }

        $hari = \Carbon\Carbon::parse($request->usulan_tanggal)->locale('id')->isoFormat('dddd');

        $izin->update([
            'status' => 'menunggu_konfirmasi_pengaju',
            'usulan_tanggal' => $request->usulan_tanggal,
            'usulan_hari' => $hari,
            'usulan_jam_mulai' => $request->usulan_jam_mulai,
            'usulan_jam_selesai' => $request->usulan_jam_selesai,
        ]);

        return redirect()->back()->with('success', 'Izin disetujui. Usulan reschedule telah dikirim ke Tutor.');
    }

    // Siswa menolak izin dari Tutor
    public function reject(Request $request, PengajuanIzin $izin)
    {
        if ($izin->jadwal->siswa_id != Auth::user()->siswa->id) {
            abort(403);
        }

        $izin->update(['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Pengajuan izin ditolak. Jadwal tetap berjalan seperti biasa.');
    }
}
