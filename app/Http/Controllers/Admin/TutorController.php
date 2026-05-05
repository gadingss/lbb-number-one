<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    // ===============================
    // # Daftar Tutor
    // ===============================
    public function index()
    {
        // Tutor Spotlight Server-side
        $spotlightTutor = Tutor::with('user')
            ->withCount('jadwals')
            ->orderByDesc('jadwals_count')
            ->first();

        $totalHours = 0;
        $totalStudents = 0;

        if ($spotlightTutor) {
            $jadwals = \App\Models\Jadwal::where('tutor_id', $spotlightTutor->id)->get();
            foreach ($jadwals as $jadwal) {
                $start = \Carbon\Carbon::parse($jadwal->jam_mulai);
                $end = \Carbon\Carbon::parse($jadwal->jam_selesai);
                // Menghitung selisih jam
                $totalHours += $end->diffInHours($start) > 0 ? $end->diffInHours($start) : 1; 
            }
            $totalStudents = \App\Models\Jadwal::where('tutor_id', $spotlightTutor->id)
                ->whereNotNull('siswa_id')
                ->distinct('siswa_id')
                ->count('siswa_id');
        }

        // Top Subject Growth
        $topSubject = "Keahlian Umum";
        $topJadwalMapel = \App\Models\Jadwal::with('mataPelajaran')
            ->select('mata_pelajaran_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('mata_pelajaran_id')
            ->orderByDesc('total')
            ->first();
            
        if ($topJadwalMapel && $topJadwalMapel->mataPelajaran) {
            $topSubject = $topJadwalMapel->mataPelajaran->nama_mapel;
        }

        // Paginated list
        $tutors = Tutor::with('user')->latest()->paginate(10);
        
        return view('admin.tutor.index', compact('tutors', 'spotlightTutor', 'totalHours', 'totalStudents', 'topSubject'));
    }

    // ===============================
    // # Form Tambah Tutor
    // ===============================
    public function create()
    {
        return view('admin.tutor.create');
    }

    // ===============================
    // # Simpan Tutor
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|numeric',
            'alamat' => 'required|string',
            'keahlian' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'kuota_siswa' => 'required|integer|min:1',
        ], [
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => 'tutor',
            ]);

            Tutor::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'keahlian' => $request->keahlian,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'kuota_siswa' => $request->kuota_siswa,
            ]);
        });

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Tutor berhasil ditambahkan beserta akun loginnya');
    }

    // ===============================
    // # Form Edit
    // ===============================
    public function edit(Tutor $tutor)
    {
        return view('admin.tutor.edit', compact('tutor'));
    }

    // ===============================
    // # Update Tutor
    // ===============================
    public function update(Request $request, Tutor $tutor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $tutor->user->id,
            'password' => 'nullable|string|min:8',
            'no_hp' => 'required|numeric',
            'alamat' => 'required|string',
            'keahlian' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'kuota_siswa' => 'required|integer|min:1',
        ], [
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $tutor) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $tutor->user->update($userData);

            $tutor->update([
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'keahlian' => $request->keahlian,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'kuota_siswa' => $request->kuota_siswa,
            ]);
        });

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Data Tutor beserta informasi Auth berhasil diperbarui');
    }

    // ===============================
    // # Hapus Tutor
    // ===============================
    public function destroy(Tutor $tutor)
    {
        $user = $tutor->user;
        $tutor->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Akun Tutor beserta profil pendidiknya berhasil dihapus secara permanen');
    }

    // ===============================
    // # Verifikasi Tutor
    // ===============================
    public function verify(Request $request, Tutor $tutor)
    {
        $request->validate([
            'kode' => 'required|string|unique:users,kode',
        ]);

        $tutor->user->update([
            'kode' => $request->kode,
            'is_verified' => true,
        ]);

        // Format No HP
        $noHp = $tutor->no_hp;
        if (substr($noHp, 0, 1) === '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        $waMessage = urlencode("Halo {$tutor->user->name}, akun Tutor Anda telah diverifikasi oleh LBB Number One. Berikut adalah kode login Anda: {$request->kode}\nSilakan login menggunakan kode ini.");
        $waLink = "https://wa.me/{$noHp}?text={$waMessage}";

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Tutor berhasil diverifikasi.')
            ->with('wa_link', $waLink);
    }
}