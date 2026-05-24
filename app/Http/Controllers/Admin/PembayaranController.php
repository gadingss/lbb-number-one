<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Paket;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // ===============================
    // INDEX - Daftar Pembayaran
    // ===============================
    public function index(Request $request)
    {
        $query = Pembayaran::with(['siswa.user', 'paket']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', strtolower($request->status));
        }

        // Date Range Filter
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_akhir);
        }

        $pembayarans = $query->latest()->paginate(10)->withQueryString();

        // Calculate Metrics
        $totalPendapatanBulanIni = Pembayaran::where('status', 'lunas')
            ->whereMonth('tanggal_bayar', \Carbon\Carbon::now()->month)
            ->whereYear('tanggal_bayar', \Carbon\Carbon::now()->year)
            ->sum('jumlah');

        $menungguKonfirmasi = Pembayaran::where('status', 'pending')->count();

        // Metode Terpopuler
        $metodeTerpopulerObj = Pembayaran::select('metode_pembayaran', \DB::raw('count(*) as total'))
            ->groupBy('metode_pembayaran')
            ->orderByDesc('total')
            ->first();
        $metodeTerpopuler = $metodeTerpopulerObj ? $metodeTerpopulerObj->metode_pembayaran : 'Belum Ada';

        return view('admin.pembayaran.index', compact(
            'pembayarans', 
            'totalPendapatanBulanIni', 
            'menungguKonfirmasi', 
            'metodeTerpopuler'
        ));
    }

    // ===============================
    // CREATE - Form Tambah Pembayaran
    // ===============================
    public function create()
    {
        $siswas = Siswa::with('user')->get();
        $pakets = Paket::with('mataPelajaran')->get();

        return view('admin.pembayaran.create', compact('siswas', 'pakets'));
    }

    // ===============================
    // STORE - Simpan Pembayaran
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'paket_id' => 'required|exists:pakets,id',
            'jumlah' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:pending,lunas,gagal',
            'keterangan' => 'nullable|string',
        ]);

        Pembayaran::create($request->all());

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil ditambahkan');
    }

    // ===============================
    // EDIT - Form Edit Pembayaran
    // ===============================
    public function edit(Pembayaran $pembayaran)
    {
        $siswas = Siswa::with('user')->get();
        $pakets = Paket::with('mataPelajaran')->get();

        return view('admin.pembayaran.edit', compact('pembayaran', 'siswas', 'pakets'));
    }

    // ===============================
    // UPDATE - Update Pembayaran
    // ===============================
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'paket_id' => 'required|exists:pakets,id',
            'jumlah' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:pending,lunas,gagal',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaran->update($request->all());

        // Jika status diubah menjadi lunas secara manual oleh Admin, pastikan jadwalnya ikut aktif
        if ($request->status === 'lunas') {
            \App\Models\Jadwal::withoutGlobalScope('exclude_pending')
                ->where('pembayaran_id', $pembayaran->id)
                ->update(['status' => 'aktif']);
        } elseif ($request->status === 'gagal') {
            \App\Models\Jadwal::withoutGlobalScope('exclude_pending')
                ->where('pembayaran_id', $pembayaran->id)
                ->delete();
        }

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil diperbarui');
    }

    // ===============================
    // DESTROY - Hapus Pembayaran
    // ===============================
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }

    // ===============================
    // LAPORAN - Cetak Laporan Pembayaran
    // ===============================
    public function laporan(Request $request)
    {
        $query = Pembayaran::with(['siswa.user', 'paket']);

        // Filter berdasarkan tanggal
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_bayar', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // Filter berdasarkan status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pembayarans = $query->latest()->get();
        
        $totalPendapatan = $pembayarans->where('status', 'lunas')->sum('jumlah');

        return view('admin.pembayaran.laporan', compact('pembayarans', 'totalPendapatan'));
    }
}
