# Sistem Bimbel Privat Laravel

Aplikasi manajemen bimbel privat dengan tiga role: Admin, Tutor, dan Siswa.

## Fitur

### Admin
- Dashboard dengan statistik
- Kelola Data Tutor
- Kelola Data Siswa
- Kelola Paket Les
- Kelola Mata Pelajaran
- Kelola Jadwal Tutor
- Kelola Pembayaran
- Kelola Kehadiran/Absensi

### Tutor
- Dashboard tutor
- Lihat Jadwal Mengajar
- Catat Absensi Siswa
- Riwayat Mengajar

### Siswa
- Dashboard siswa
- Lihat Paket Les
- Pesan Paket
- Lihat Jadwal
- Riwayat Pembelajaran

## Cara Install dan Menjalankan

### 1. Install Dependencies
```
bash
cd lbb_number_one
composer install
```

### 2. Setup Environment
```
bash
cp .env.example .env
php artisan key:generate
```

### 3. Setup Database
Edit file `.env` sesuai konfigurasi database Anda, kemudian:
```
bash
php artisan migrate
php artisan db:seed
```

### 4. Build Assets
```
bash
npm install
npm run build
```

### 5. Menjalankan Server
```
bash
php artisan serve
```

## Akun Login (Setelah Seeding)

| Role   | Email              | Password |
|--------|--------------------|----------|
| Admin  | admin@bimbel.com   | password |
| Tutor  | tutor@bimbel.com   | password |
| Tutor  | tutor2@bimbel.com  | password |
| Siswa  | siswa@bimbel.com   | password |

## Teknologi

- Laravel 12
- PHP 8.2+
- Tailwind CSS
- MySQL/SQLite

## Lisensi

MIT
