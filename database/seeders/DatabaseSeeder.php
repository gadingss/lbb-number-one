<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tutor;
use App\Models\Siswa;
use App\Models\Paket;
use App\Models\MataPelajaran;
use App\Models\Jadwal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Admin
        $admin = User::create([
            'kode' => 'admin123',
            'name' => 'Admin Bimbel',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // User Tutor
        $userTutor = User::create([
            'kode' => 'tutor123',
            'name' => 'Budi Santoso',
            'email' => 'tutor@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'tutor',
            'is_verified' => true,
        ]);

        $tutor = Tutor::create([
            'user_id' => $userTutor->id,
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'keahlian' => 'Matematika, Fisika',
            'pendidikan_terakhir' => 'S1 Pendidikan Matematika',
        ]);

        // User Tutor 2
        $userTutor2 = User::create([
            'kode' => 'tutor456',
            'name' => 'Siti Rahayu',
            'email' => 'tutor2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'tutor',
            'is_verified' => true,
        ]);

        Tutor::create([
            'user_id' => $userTutor2->id,
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Sudirman No. 20, Jakarta',
            'keahlian' => 'Kimia, Biologi',
            'pendidikan_terakhir' => 'S1 Pendidikan Kimia',
        ]);

        // User Siswa
        $userSiswa = User::create([
            'kode' => 'siswa123',
            'name' => 'Ahmad Fauzi',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'is_verified' => true,
        ]);

        $siswa = Siswa::create([
            'user_id' => $userSiswa->id,
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Asia Afrika No. 5, Jakarta',
            'sekolah' => 'SMA Negeri 1 Jakarta',
            'kelas' => '10',
        ]);

        // Mata Pelajaran (didefinisikan dulu sebelum Paket)
        $mapel1 = MataPelajaran::create([
            'nama_mapel' => 'Matematika',
            'deskripsi' => 'Matematika SMA/SMK',
        ]);

        $mapel2 = MataPelajaran::create([
            'nama_mapel' => 'Fisika',
            'deskripsi' => 'Fisika SMA/SMK',
        ]);

        $mapel3 = MataPelajaran::create([
            'nama_mapel' => 'Kimia',
            'deskripsi' => 'Kimia SMA/SMK',
        ]);

        $mapel4 = MataPelajaran::create([
            'nama_mapel' => 'Biologi',
            'deskripsi' => 'Biologi SMA/SMK',
        ]);

        // Paket (setelah mata_pelajaran didefinisikan)
        $paket1 = Paket::create([
            'nama_paket' => 'Paket Reguler',
            'mata_pelajaran_id' => $mapel1->id,
            'jumlah_pertemuan' => 8,
            'harga' => 500000,
            'deskripsi' => '8 sesi per bulan',
        ]);

        $paket2 = Paket::create([
            'nama_paket' => 'Paket Intensif',
            'mata_pelajaran_id' => $mapel1->id,
            'jumlah_pertemuan' => 12,
            'harga' => 750000,
            'deskripsi' => '12 sesi per bulan',
        ]);

        $paket3 = Paket::create([
            'nama_paket' => 'Paket Super Intensif',
            'mata_pelajaran_id' => $mapel2->id,
            'jumlah_pertemuan' => 16,
            'harga' => 1000000,
            'deskripsi' => '16 sesi per bulan',
        ]);

        // Jadwal
        Jadwal::create([
            'tutor_id' => $tutor->id,
            'mata_pelajaran_id' => $mapel1->id,
            'hari' => 'Senin',
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
        ]);

        Jadwal::create([
            'tutor_id' => $tutor->id,
            'mata_pelajaran_id' => $mapel2->id,
            'hari' => 'Rabu',
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
        ]);

        echo "Database seeded successfully!\n";
        echo "Login credentials:\n";
        echo "Admin: admin@gmail.com / password\n";
        echo "Tutor: tutor@gmail.com / password\n";
        echo "Siswa: siswa@gmail.com / password\n";
    }
}
