<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:siswa,tutor'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'sekolah' => ['required_if:role,siswa', 'nullable', 'string'],
            'kelas' => ['required_if:role,siswa', 'nullable', 'string'],
            'keahlian' => ['required_if:role,tutor', 'nullable', 'string'],
            'pendidikan_terakhir' => ['required_if:role,tutor', 'nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_verified' => false,
        ]);

        if ($request->role === 'siswa') {
            \App\Models\Siswa::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'kelas' => $request->kelas,
                'sekolah' => $request->sekolah
            ]);
        } else {
            \App\Models\Tutor::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'keahlian' => $request->keahlian,
                'pendidikan_terakhir' => $request->pendidikan_terakhir
            ]);
        }

        event(new Registered($user));

        // Kirim Notifikasi WhatsApp ke User yang mendaftar
        try {
            $fonnte = app(\App\Services\FonnteService::class);
            $pesan = "🎉 *PENDAFTARAN BERHASIL*\n\n"
                   . "Halo {$request->name},\n"
                   . "Pendaftaran Anda sebagai *" . strtoupper($request->role) . "* di LBB Number One telah berhasil diterima.\n\n"
                   . "Mohon tunggu sejenak. Tim Admin kami sedang melakukan verifikasi data Anda.\n"
                   . "Kode login akan dikirimkan melalui WhatsApp setelah akun Anda diverifikasi.\n\n"
                   . "Terima kasih telah bergabung!\n"
                   . "- *LBB Number One*";
                   
            $fonnte->sendMessage($request->no_hp, $pesan);
            \Illuminate\Support\Facades\Log::info("Fonnte Registration Notification Sent to {$request->no_hp}");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Fonnte Registration Error: " . $e->getMessage());
        }

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil. Silakan tunggu verifikasi dan kode login dari Admin via WhatsApp.');
    }
}
