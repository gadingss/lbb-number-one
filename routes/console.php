<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Jadwal;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Pengingat Kelas 2 Jam Sebelum Mulai
Schedule::call(function () {
    // Cari waktu 2 jam dari sekarang
    $targetTime = Carbon::now()->addHours(2);
    $hariIni = $targetTime->locale('id')->isoFormat('dddd');
    $jamTarget = $targetTime->format('H:i'); // format HH:MM
    
    // Cari jadwal yang hari dan jam mulainya (di menit yang sama) cocok
    $jadwals = Jadwal::with(['siswa.user', 'tutor.user', 'mataPelajaran'])
        ->where('hari', $hariIni)
        ->whereRaw('DATE_FORMAT(jam_mulai, "%H:%i") = ?', [$jamTarget])
        ->get();

    if ($jadwals->count() > 0) {
        $fonnte = app(FonnteService::class);
        
        foreach ($jadwals as $jadwal) {
            $jamMulai = substr($jadwal->jam_mulai, 0, 5);
            $namaMapel = $jadwal->mataPelajaran->nama_mapel ?? 'Mata Pelajaran';
            
            // Kirim ke Siswa
            if ($jadwal->siswa && $jadwal->siswa->no_hp) {
                $namaSiswa = $jadwal->siswa->user->name ?? 'Siswa';
                $msgSiswa = "🔔 *PENGINGAT KELAS*\n\n"
                          . "Halo {$namaSiswa},\n"
                          . "Kelas *{$namaMapel}* Anda akan dimulai dalam *2 jam* lagi pada pukul *{$jamMulai}*.\n\n"
                          . "Jangan lupa bersiap-siap ya! Semangat belajarnya! 🚀\n"
                          . "- *LBB Number One*";
                $fonnte->sendMessage($jadwal->siswa->no_hp, $msgSiswa);
                Log::info("Fonnte Reminder Sent to Siswa ID {$jadwal->siswa->id} for Jadwal ID {$jadwal->id}");
            }
            
            // Kirim ke Tutor
            if ($jadwal->tutor && $jadwal->tutor->no_hp) {
                $namaTutor = $jadwal->tutor->user->name ?? 'Tutor';
                $namaSiswa = $jadwal->siswa->user->name ?? 'Siswa';
                $msgTutor = "🔔 *PENGINGAT MENGAJAR*\n\n"
                          . "Halo {$namaTutor},\n"
                          . "Anda memiliki jadwal mengajar kelas *{$namaMapel}* bersama *{$namaSiswa}* dalam *2 jam* lagi pada pukul *{$jamMulai}*.\n\n"
                          . "Mohon persiapkan materi dengan baik. Terima kasih! 🎓\n"
                          . "- *LBB Number One*";
                $fonnte->sendMessage($jadwal->tutor->no_hp, $msgTutor);
                Log::info("Fonnte Reminder Sent to Tutor ID {$jadwal->tutor->id} for Jadwal ID {$jadwal->id}");
            }
        }
    }
})->everyMinute();
