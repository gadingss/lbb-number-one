<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// ================= ADMIN =================
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TutorController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\AbsensiController;

// ================= TUTOR =================
use App\Http\Controllers\Tutor\DashboardController as TutorDashboardController;
use App\Http\Controllers\Tutor\AbsensiController as TutorAbsensiController;

// ================= SISWA =================
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PaketController as SiswaPaketController;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayatController;


/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD UNIVERSAL (Redirect Role)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'tutor' => redirect()->route('tutor.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
        default => abort(403)
    };

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('tutor', TutorController::class);
        Route::post('tutor/{tutor}/verify', [TutorController::class, 'verify'])->name('tutor.verify');
        Route::resource('siswa', SiswaController::class);
        Route::post('siswa/{siswa}/verify', [SiswaController::class, 'verify'])->name('siswa.verify');
        Route::resource('paket', PaketController::class);
        Route::resource('mata-pelajaran', MataPelajaranController::class);
        Route::resource('jadwal', JadwalController::class);
        
        // Pembayaran
        Route::resource('pembayaran', PembayaranController::class);
        Route::get('pembayaran/laporan', [PembayaranController::class, 'laporan'])
            ->name('pembayaran.laporan');
        
        // Absensi
        Route::resource('absensi', AbsensiController::class);
        Route::get('absensi/rekap', [AbsensiController::class, 'rekap'])
            ->name('absensi.rekap');
});


/*
|--------------------------------------------------------------------------
| TUTOR ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:tutor'])
    ->prefix('tutor')
    ->name('tutor.')
    ->group(function () {

        Route::get('/dashboard', [TutorDashboardController::class, 'index'])
            ->name('dashboard');

        // Jadwal
        Route::get('jadwal', [App\Http\Controllers\Tutor\JadwalController::class, 'index'])
            ->name('jadwal.index');

        // Absensi
        Route::resource('absensi', TutorAbsensiController::class);
        Route::get('riwayat', [TutorAbsensiController::class, 'riwayat'])
            ->name('riwayat.index');

        // Fitur Izin / Reschedule (Tutor)
        Route::post('/izin', [\App\Http\Controllers\Tutor\IzinController::class, 'store'])->name('izin.store');
        Route::post('/izin/{izin}/approve', [\App\Http\Controllers\Tutor\IzinController::class, 'approve'])->name('izin.approve');
        Route::post('/izin/{izin}/reject', [\App\Http\Controllers\Tutor\IzinController::class, 'reject'])->name('izin.reject');
        Route::post('/izin/{izin}/accept', [\App\Http\Controllers\Tutor\IzinController::class, 'acceptReschedule'])->name('izin.accept');
    });


/*
|--------------------------------------------------------------------------
| SISWA ROUTES
|--------------------------------------------------------------------------
*/

// ======================================
// # Routes untuk SISWA
// ======================================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    // Fitur Riwayat Siswa
    Route::get('/riwayat', [SiswaRiwayatController::class, 'index'])->name('riwayat.index');

    // Fitur Izin / Reschedule (Siswa)
    Route::post('/izin', [\App\Http\Controllers\Siswa\IzinController::class, 'store'])->name('izin.store');
    Route::post('/izin/{izin}/approve', [\App\Http\Controllers\Siswa\IzinController::class, 'approve'])->name('izin.approve');
    Route::post('/izin/{izin}/reject', [\App\Http\Controllers\Siswa\IzinController::class, 'reject'])->name('izin.reject');
    Route::post('/izin/{izin}/accept', [\App\Http\Controllers\Siswa\IzinController::class, 'acceptReschedule'])->name('izin.accept');


    // Paket
    Route::resource('paket', SiswaPaketController::class)->only(['index']);
    Route::post('paket/pesan', [SiswaPaketController::class, 'pesan'])
        ->name('paket.pesan');

    // Jadwal
    Route::resource('jadwal', SiswaJadwalController::class)->only(['index']);

    // Riwayat
    Route::resource('riwayat', SiswaRiwayatController::class)->only(['index']);
    Route::post('riwayat/{absensi}/konfirmasi', [SiswaRiwayatController::class, 'konfirmasi'])
        ->name('riwayat.konfirmasi');
});


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| WEBHOOKS
|--------------------------------------------------------------------------
*/
Route::post('/api/midtrans/callback', [\App\Http\Controllers\Webhook\MidtransController::class, 'callback'])->name('midtrans.callback');