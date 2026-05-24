<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // ===============================
    // INDEX - Riwayat Pembayaran Siswa
    // ===============================
    public function index()
    {
        $user = auth()->user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $pembayarans = Pembayaran::with(['paket'])
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('id')
            ->paginate(15);

        return view('siswa.pembayaran.index', compact('pembayarans'));
    }
}
