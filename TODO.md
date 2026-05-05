# TODO LIST - LBB Private System

## FASE 1: DATABASE MIGRATIONS
- [ ] Buat migration untuk tabel pembayaran
- [ ] Buat migration untuk tabel absensi
- [ ] Buat migration untuk tabel transaksi/paket_siswa

## FASE 2: MODELS & RELATIONSHIPS
- [ ] Update model Jadwal dengan relasi
- [ ] Buat model Pembayaran
- [ ] Buat model Absensi
- [ ] Buat model Transaksi (PaketSiswa)

## FASE 3: ADMIN FEATURES
### A. Kelola Jadwal (View & CRUD)
- [ ] Buat view admin/jadwal/index.blade.php
- [ ] Buat view admin/jadwal/create.blade.php
- [ ] Buat view admin/jadwal/edit.blade.php

### B. Kelola Pembayaran
- [ ] Buat PembayaranController
- [ ] Buat migration dan model untuk pembayaran
- [ ] Buat view admin/pembayaran/index.blade.php
- [ ] Buat view admin/pembayaran/create.blade.php
- [ ] Fitur print laporan pembayaran

### C. Kelola Absensi/Kehadiran
- [ ] Buat AbsensiController
- [ ] Buat view admin/absensi/index.blade.php
- [ ] Fitur rekap kehadiran tutor

## FASE 4: TUTOR FEATURES
### A. Dashboard Tutor
- [ ] Perbaiki view tutor/dashboard.blade.php

### B. Jadwal Mengajar
- [ ] Buat view tutor/jadwal/index.blade.php

### C. Catat Kehadiran & Hasil Pertemuan
- [ ] Buat AbsensiController untuk tutor
- [ ] Buat view tutor/absensi/create.blade.php
- [ ] Buat view tutor/absensi/index.blade.php

### D. Riwayat Mengajar
- [ ] Buat view tutor/riwayat/index.blade.php

### E. Profil Tutor
- [ ] Buat route dan controller untuk update profil

## FASE 5: SISWA FEATURES
### A. Dashboard Siswa
- [ ] Perbaiki view siswa/dashboard.blade.php

### B. Pilih Paket & Mata Pelajaran
- [ ] Buat TransaksiController
- [ ] Buat view siswa/paket/index.blade.php (list paket)
- [ ] Buat view siswa/transaksi/create.blade.php (beli paket)

### C. Jadwal Les
- [ ] Buat view siswa/jadwal/index.blade.php

### D. Konfirmasi Kehadiran
- [ ] Buat view siswa/absensi/index.blade.php
- [ ] Fitur konfirmasi kehadiran

### E. Riwayat & Pembayaran
- [ ] Buat view siswa/riwayat/index.blade.php
- [ ] Tampilkan status pembayaran

## FASE 6: ROUTES & NAVIGATION
- [ ] Update routes/web.php
- [ ] Update layout dengan dynamic sidebar per role

## FASE 7: SEEDER & TESTING
- [ ] Buat DatabaseSeeder dengan data dummy
- [ ] Testing semua fitur
