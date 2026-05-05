<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // ===============================
    // # Daftar Siswa
    // ===============================
    public function index()
    {
        $siswas = Siswa::with('user')->latest()->paginate(15);
        $totalSiswa = Siswa::count();
        return view('admin.siswa.index', compact('siswas', 'totalSiswa'));
    }

    // ===============================
    // # Form Tambah Siswa
    // ===============================
    public function create()
    {
        return view('admin.siswa.create');
    }

    // ===============================
    // # Simpan Siswa
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp'   => 'required|numeric',
            'alamat'  => 'required|string',
            'kelas'   => 'required|string|max:50',
            'sekolah' => 'required|string|max:255',
        ], [
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'kelas' => $request->kelas,
                'sekolah' => $request->sekolah,
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan beserta akun loginnya');
    }

    // ===============================
    // # Form Edit
    // ===============================
    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    // ===============================
    // # Update Siswa
    // ===============================
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $siswa->user->id,
            'password' => 'nullable|string|min:8',
            'no_hp'   => 'required|numeric',
            'alamat'  => 'required|string',
            'kelas'   => 'required|string|max:50',
            'sekolah' => 'required|string|max:255',
        ], [
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $siswa) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $siswa->user->update($userData);

            $siswa->update([
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'kelas' => $request->kelas,
                'sekolah' => $request->sekolah,
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data Siswa beserta informasi kredensial login berhasil diperbarui');
    }

    // ===============================
    // # Hapus Siswa
    // ===============================
    public function destroy(Siswa $siswa)
    {
        $user = $siswa->user;
        $siswa->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Akun Siswa beserta profil belajarnya berhasil dihapus permanen');
    }

    // ===============================
    // # Verifikasi Siswa
    // ===============================
    public function verify(Request $request, Siswa $siswa)
    {
        $request->validate([
            'kode' => 'required|string|unique:users,kode',
        ]);

        $siswa->user->update([
            'kode' => $request->kode,
            'is_verified' => true,
        ]);

        // Format No HP
        $noHp = $siswa->no_hp;
        if (substr($noHp, 0, 1) === '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        $waMessage = urlencode("Halo {$siswa->user->name}, akun Anda telah diverifikasi oleh LBB Number One. Berikut adalah kode login Anda: {$request->kode}\nSilakan login menggunakan kode ini.");
        $waLink = "https://wa.me/{$noHp}?text={$waMessage}";

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diverifikasi.')
            ->with('wa_link', $waLink);
    }
}