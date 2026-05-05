<?php

namespace App\Services;

use App\Models\Jadwal;
use App\Models\JadwalPengganti;
use Carbon\Carbon;

class JadwalService
{
    /**
     * Cek apakah usulan jadwal (tanggal, jam mulai, jam selesai) bentrok dengan
     * jadwal tutor atau siswa.
     */
    public static function isJadwalAvailable($tutorId, $siswaId, $tanggal, $jamMulai, $jamSelesai)
    {
        // Bahasa Indonesia hari: Senin, Selasa, dst
        $hari = Carbon::parse($tanggal)->locale('id')->isoFormat('dddd');

        // 1. Cek bentrok di tabel Jadwal (rutin)
        $bentrokJadwal = Jadwal::where(function($q) use ($tutorId, $siswaId) {
            $q->where('tutor_id', $tutorId)
              ->orWhere('siswa_id', $siswaId);
        })
        ->where('hari', $hari)
        ->where('status', 'aktif')
        ->where(function ($q) use ($jamMulai, $jamSelesai) {
            $q->where(function ($q2) use ($jamMulai, $jamSelesai) {
                $q2->where('jam_mulai', '<=', $jamMulai)
                   ->where('jam_selesai', '>', $jamMulai);
            })->orWhere(function ($q2) use ($jamMulai, $jamSelesai) {
                $q2->where('jam_mulai', '<', $jamSelesai)
                   ->where('jam_selesai', '>=', $jamSelesai);
            })->orWhere(function ($q2) use ($jamMulai, $jamSelesai) {
                $q2->where('jam_mulai', '>=', $jamMulai)
                   ->where('jam_selesai', '<=', $jamSelesai);
            });
        })->exists();

        if ($bentrokJadwal) {
            return false;
        }

        // 2. Cek bentrok di tabel JadwalPengganti (reschedule)
        $bentrokPengganti = JadwalPengganti::whereHas('jadwal', function($q) use ($tutorId, $siswaId) {
            $q->where('tutor_id', $tutorId)
              ->orWhere('siswa_id', $siswaId);
        })
        ->where('tanggal_pengganti', $tanggal)
        ->whereIn('status', ['menunggu_dilaksanakan'])
        ->where(function ($q) use ($jamMulai, $jamSelesai) {
            $q->where(function ($q2) use ($jamMulai, $jamSelesai) {
                $q2->where('jam_mulai', '<=', $jamMulai)
                   ->where('jam_selesai', '>', $jamMulai);
            })->orWhere(function ($q2) use ($jamMulai, $jamSelesai) {
                $q2->where('jam_mulai', '<', $jamSelesai)
                   ->where('jam_selesai', '>=', $jamSelesai);
            })->orWhere(function ($q2) use ($jamMulai, $jamSelesai) {
                $q2->where('jam_mulai', '>=', $jamMulai)
                   ->where('jam_selesai', '<=', $jamSelesai);
            });
        })->exists();

        if ($bentrokPengganti) {
            return false;
        }

        return true;
    }
}
