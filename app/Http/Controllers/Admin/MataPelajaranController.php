<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    // ===============================
    // # Daftar Mata Pelajaran
    // ===============================
    public function index()
    {
        $mataPelajarans = MataPelajaran::latest()->get();
        return view('admin.mata_pelajaran.index', compact('mataPelajarans'));
    }

    // ===============================
    // # Form Tambah
    // ===============================
    public function create()
    {
        return view('admin.mata_pelajaran.create');
    }

    // ===============================
    // # Simpan
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:mata_pelajarans,nama',
            'deskripsi' => 'nullable|string',
        ]);

        MataPelajaran::create($request->only(['nama', 'deskripsi']));

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    // ===============================
    // # Form Edit
    // ===============================
    public function edit(MataPelajaran $mata_pelajaran)
    {
        return view('admin.mata_pelajaran.edit', compact('mata_pelajaran'));
    }

    // ===============================
    // # Update
    // ===============================
    public function update(Request $request, MataPelajaran $mata_pelajaran)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:mata_pelajarans,nama,' . $mata_pelajaran->id,
            'deskripsi' => 'nullable|string',
        ]);

        $mata_pelajaran->update($request->only(['nama', 'deskripsi']));

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    // ===============================
    // # Hapus
    // ===============================
    public function destroy(MataPelajaran $mata_pelajaran)
    {
        $mata_pelajaran->delete();

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus');
    }
}