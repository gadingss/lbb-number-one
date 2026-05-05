<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // ===============================
    // # Daftar Paket
    // ===============================
    public function index()
    {
        $pakets = Paket::latest()->paginate(10);
        
        $totalPaket = Paket::count();
        $avgPrice = Paket::avg('harga') ?? 0;
        $topPaket = Paket::withCount('pembayarans')
            ->orderByDesc('pembayarans_count')
            ->first();

        return view('admin.paket.index', compact('pakets', 'totalPaket', 'avgPrice', 'topPaket'));
    }

    // ===============================
    // # Form Tambah
    // ===============================
    public function create()
    {
        return view('admin.paket.create');
    }

    // ===============================
    // # Simpan Paket
    // ===============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'jumlah_pertemuan' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Paket::create($validated);

        return redirect()->route('admin.paket.index')
            ->with('success', 'Paket berhasil ditambahkan');
    }

    // ===============================
    // # Form Edit
    // ===============================
    public function edit(Paket $paket)
    {
        return view('admin.paket.edit', compact('paket'));
    }

    // ===============================
    // # Update Paket
    // ===============================
    public function update(Request $request, Paket $paket)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'jumlah_pertemuan' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $paket->update($validated);

        return redirect()->route('admin.paket.index')
            ->with('success', 'Paket berhasil diperbarui');
    }

    // ===============================
    // # Hapus Paket
    // ===============================
    public function destroy(Paket $paket)
    {
        $paket->delete();

        return redirect()->route('admin.paket.index')
            ->with('success', 'Paket berhasil dihapus');
    }
}