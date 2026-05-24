# 🔍 Cross-Check Report — Bug List LBB Number One

Hasil investigasi terhadap 9 issue yang dilaporkan. Tiap issue diberi status temuan dan analisis teknis.

---

## 1. ❌ Tampilan Harus Bertanggung Jawab (Responsive)

**Status:** 🔴 **CONFIRMED — BUG**

**Temuan:**
- Layout **Siswa** ([siswa.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/layouts/siswa.blade.php)) menggunakan **sidebar fixed `w-64`** (lebar tetap 256px) dan main content `ml-64`. **Tidak ada hamburger menu atau collapsible sidebar untuk mobile.**
- Top App Bar juga fixed `left-64`, artinya di layar kecil sidebar tetap menempel dan tidak bisa di-hide.
- Halaman [siswa/riwayat/index.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/siswa/riwayat/index.blade.php) menggunakan `<table>` full tanpa `overflow-x-auto`, jadi di mobile tabel **terpotong** dan tidak bisa scroll horizontal.
- Layout **Tutor** ([tutor.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/layouts/tutor.blade.php)) kemungkinan punya masalah serupa (ukuran file mirip).
- Layout **Admin** ([app.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/layouts/app.blade.php)) perlu dicek juga.

**Yang perlu difix:**
- Tambah mobile hamburger menu & collapsible sidebar
- Konversi sidebar jadi off-canvas di layar `< md`
- Wrap semua `<table>` dengan `overflow-x-auto`
- Pastikan semua card/grid menggunakan responsive breakpoint

---

## 2. ⚠️ Konfirmasi Sebelum/Sesudah (BUG)

**Status:** 🔴 **CONFIRMED — BUG**

**Temuan:**
- Di halaman [siswa/paket/index.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/siswa/paket/index.blade.php), tombol "Pilih Paket" langsung `submit` form POST tanpa **dialog konfirmasi** apapun (line 70-76, 118-124, 156-162).
- Saat klik tombol, langsung diarahkan ke proses Midtrans → record `pembayaran` langsung dibuat dengan status `pending`.
- **Tidak ada modal confirm** "Apakah Anda yakin ingin memesan paket ini?"
- Halaman [bayar.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/siswa/paket/bayar.blade.php) bahkan **auto-trigger payment popup** di `DOMContentLoaded` (line 67-69), sehingga user langsung dihadapkan ke Midtrans Snap tanpa waktu review.

**Yang perlu difix:**
- Tambah modal konfirmasi sebelum submit form "Pilih Paket"
- Tampilkan ringkasan pesanan sebelum auto-trigger pembayaran
- Opsional: tambah halaman konfirmasi terpisah sebelum masuk ke Midtrans

---

## 3. ⚠️ Bagaimana Jika Semua Tutor Sudah Full? (Sold Out)

**Status:** 🟡 **PARTIALLY HANDLED — PERLU IMPROVEMENT**

**Temuan:**
- Di [Admin/JadwalController.php](file:///c:/laragon/www/lbb_number_one/app/Http/Controllers/Admin/JadwalController.php) (line 57-58), sudah ada pengecekan kuota:
  ```php
  if ($tutor && $tutor->active_students_count >= $tutor->kuota_siswa) {
      return back()->withErrors(['tutor_id' => 'Gagal: Tutor ini sudah mencapai batas maksimum kuota siswa (Penuh).']);
  }
  ```
- **TAPI**, pengecekan ini hanya di sisi **Admin saat membuat jadwal**, bukan di sisi **Siswa saat memilih paket**.
- Di halaman [siswa/paket/index.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/siswa/paket/index.blade.php), **tidak ada indikasi apapun** apakah tutor masih tersedia atau sudah full.
- Siswa tetap bisa membeli paket via Midtrans meskipun semua tutor sudah full → uang sudah dibayar, tapi tidak bisa dapat tutor.
- Model [Tutor.php](file:///c:/laragon/www/lbb_number_one/app/Models/Tutor.php) punya atribut `kuota_siswa` dan computed `active_students_count`.

**Yang perlu difix:**
- Cek di [Siswa/PaketController.php](file:///c:/laragon/www/lbb_number_one/app/Http/Controllers/Siswa/PaketController.php) apakah masih ada tutor available sebelum memproses pemesanan
- Jika semua tutor sudah full, tampilkan badge "SOLD OUT" di card paket & disable tombol
- Pass data ketersediaan tutor ke view

---

## 4. ❌ Riwayat Pembayaran vs Tagihan — Istilah Tidak Konsisten

**Status:** 🔴 **CONFIRMED — INCONSISTENCY**

**Temuan:**
- Di [siswa/dashboard.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/siswa/dashboard.blade.php):
  - **Line 132**: Header menggunakan istilah **"Riwayat Pembayaran"**
  - **Line 133**: Link menggunakan istilah **"Lihat Semua Tagihan"** → link ini juga mengarah ke `#` (tidak berfungsi)
- Di sidebar [layouts/siswa.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/layouts/siswa.blade.php):
  - **Line 128**: Menu menggunakan **"Riwayat Les"** (bukan Riwayat Pembayaran)
  - Tidak ada menu khusus untuk **Riwayat Pembayaran** di sidebar
- Siswa **RiwayatController** hanya menampilkan riwayat **absensi/les**, bukan riwayat pembayaran.
- **Tidak ada halaman dedicated** untuk riwayat pembayaran bagi siswa. Data pembayaran hanya muncul di dashboard (5 terakhir).

**Yang perlu difix:**
- Konsistenkan istilah: pilih "Riwayat Pembayaran" atau "Tagihan" (jangan campur)
- Fix link "Lihat Semua Tagihan" yang mengarah ke `#`
- Buat halaman khusus riwayat pembayaran untuk siswa, atau gabungkan dengan yang sudah ada
- Tambah menu di sidebar jika diperlukan

---

## 5. ❌ Siswa Bisa Bayar Lagi Padahal Sudah Punya Paket Aktif

**Status:** 🔴 **CONFIRMED — BUG**

**Temuan:**
- Di [Siswa/PaketController.php](file:///c:/laragon/www/lbb_number_one/app/Http/Controllers/Siswa/PaketController.php), method `pesan()` (line 39-119):
  - **Tidak ada pengecekan** apakah siswa sudah punya pembayaran `pending` atau paket yang masih `lunas`.
  - Siswa bisa klik "Pilih Paket" berulang kali → **setiap klik membuat record `pembayaran` baru** dengan status `pending` + order ID baru → setiap kali membuat snap token Midtrans baru.
- Di view `index.blade.php`, meskipun ada banner "Anda memiliki paket aktif", tombol "Pilih Paket" **tetap aktif dan bisa diklik** (line 70-76).

> [!CAUTION]
> Ini bisa menyebabkan **duplikasi pembayaran** dan **masalah data** — siswa bisa membayar 2x untuk paket berbeda atau bahkan paket yang sama.

**Yang perlu difix:**
- Tambah validasi di `pesan()`: jika sudah ada pembayaran `pending` → tolak dan arahkan ke halaman pembayaran yang pending
- Jika sudah ada paket `lunas` yang masih aktif → tolak atau beri warning
- Disable tombol "Pilih Paket" di view jika sudah ada paket aktif
- Opsi: tampilkan tombol "Perpanjang Paket" hanya jika sisa sesi sudah habis

---

## 6. ❌ Tanggal Bayar Tidak Sesuai

**Status:** 🔴 **CONFIRMED — BUG**

**Temuan:**
- Di [Siswa/PaketController.php](file:///c:/laragon/www/lbb_number_one/app/Http/Controllers/Siswa/PaketController.php) line 63:
  ```php
  'tanggal_bayar' => now(),
  ```
  `tanggal_bayar` di-set saat **record dibuat** (status `pending`), bukan saat **pembayaran benar-benar lunas**.
- Di [MidtransController.php](file:///c:/laragon/www/lbb_number_one/app/Http/Controllers/Webhook/MidtransController.php) line 32-33, saat callback `settlement`/`capture`:
  ```php
  $pembayaran->update(['status' => 'lunas']);
  ```
  **Tanggal bayar TIDAK di-update** ke waktu pembayaran sebenarnya.
- Akibatnya, `tanggal_bayar` selalu menunjukkan **waktu saat klik "Pilih Paket"**, bukan saat uang benar-benar dibayarkan. Jika siswa baru bayar keesokan harinya, tanggal tetap hari sebelumnya.

**Yang perlu difix:**
- Set `tanggal_bayar` ke `null` saat record dibuat (status pending)
- Update `tanggal_bayar` di MidtransController saat status berubah ke `lunas`:
  ```php
  $pembayaran->update(['status' => 'lunas', 'tanggal_bayar' => now()]);
  ```

---

## 7. ❌ Pembayaran BUG

**Status:** 🔴 **CONFIRMED — MULTIPLE BUGS**

**Temuan beberapa masalah terkait pembayaran:**

### 7a. Midtrans Callback tanpa CSRF exemption
- Route webhook di [web.php](file:///c:/laragon/www/lbb_number_one/routes/web.php) line 185:
  ```php
  Route::post('/api/midtrans/callback', ...)->name('midtrans.callback');
  ```
  Route ini ada di `web.php` (bukan `api.php`), artinya **terkena CSRF middleware**. Midtrans tidak akan bisa mengirim callback karena tidak punya CSRF token. Ini harus dipindah ke `api.php` atau di-exclude dari CSRF.

### 7b. Tidak ada penanganan pembayaran expired
- Di MidtransController, jika Midtrans tidak pernah mengirim callback (misalnya user menutup Snap popup tanpa bayar), record pembayaran tetap `pending` selamanya.
- Tidak ada scheduled task untuk clean-up pembayaran pending yang sudah expired.

### 7c. Race condition pada pembuatan pembayaran
- Seperti issue #5, karena tidak ada lock/check, bisa terjadi multiple pending payments.

### 7d. `tanggal_bayar` sudah dibahas di issue #6

**Yang perlu difix:**
- Pindah route callback ke `api.php` atau exclude dari CSRF verification
- Tambah cron job untuk expire pembayaran pending setelah X jam
- Tambah validasi duplikasi di method `pesan()`

---

## 8. ⚠️ Paket Belum Fix

**Status:** 🟡 **PERLU KLARIFIKASI + CONFIRMED ISSUE**

**Temuan:**
- Model [Paket.php](file:///c:/laragon/www/lbb_number_one/app/Models/Paket.php) memiliki field: `nama_paket`, `mata_pelajaran_id`, `jumlah_pertemuan`, `harga`, `deskripsi`
- Migration [create_pakets_table](file:///c:/laragon/www/lbb_number_one/database/migrations/2026_02_20_140000_create_pakets_table.php) juga hanya memiliki field di atas.
- **TAPI** di view [siswa/paket/index.blade.php](file:///c:/laragon/www/lbb_number_one/resources/views/siswa/paket/index.blade.php), ada referensi ke **`$paket->durasi_pertemuan`** (line 64, 107, 150) — **field ini TIDAK ADA di database maupun model!** → Ini akan menampilkan `null` atau kosong.
- Paket ke-2 selalu diberi badge "Paling Populer" berdasarkan `$loop->iteration % 3 == 2`, **bukan berdasarkan data aktual** → hardcoded.
- Paket juga belum punya field seperti: `is_active`, `kuota_max`, `tanggal_berlaku`, atau mekanisme status enable/disable.

**Yang perlu difix:**
- Tambah kolom `durasi_pertemuan` ke tabel `pakets` (migration baru)
- Atau hapus referensi `durasi_pertemuan` dari view jika tidak diperlukan
- Implementasi logic "Paling Populer" berdasarkan data riil (jumlah pembelian)
- Tentukan field apa saja yang masih kurang di paket (klarifikasi dengan stakeholder)

---

## 9. ⚠️ Hari di-Fix kan

**Status:** 🟡 **PERLU KLARIFIKASI**

**Temuan:**
- Model [Jadwal.php](file:///c:/laragon/www/lbb_number_one/app/Models/Jadwal.php) menyimpan `hari` sebagai `string` (free text).
- Di [Admin/JadwalController.php](file:///c:/laragon/www/lbb_number_one/app/Http/Controllers/Admin/JadwalController.php) line 51: validasi hanya `'hari' => 'required|string|max:20'`.
- **Tidak ada validasi** apakah hari yang diinput valid (Senin, Selasa, dll) — bisa diisi apapun.
- Di halaman siswa dashboard, jadwal ditampilkan sebagai `$jadwal->hari` (line 192) — ini bisa inkonsisten jika ada yang input "senin" vs "Senin" vs "SENIN".

**Kemungkinan maksud "Hari di-fix kan":**
1. Jadikan `hari` sebagai **enum** atau **select dropdown** dengan pilihan fix (Senin–Minggu)
2. Gunakan validasi `in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu`
3. Pastikan case-sensitive konsisten

**Yang perlu difix:**
- Ubah input `hari` di form create/edit jadwal menjadi **dropdown/select** dengan opsi tetap
- Tambah validasi `in:Senin,Selasa,...` di controller
- Standarisasi data yang sudah ada di database

---

## 📊 Ringkasan

| # | Issue | Status | Severity |
|---|-------|--------|----------|
| 1 | Responsive | 🔴 Confirmed | **High** |
| 2 | Konfirmasi sebelum/sesudah | 🔴 Confirmed | **Medium** |
| 3 | Tutor full → Sold Out | 🟡 Partial | **High** |
| 4 | Istilah tidak konsisten | 🔴 Confirmed | **Low** |
| 5 | Double payment | 🔴 Confirmed | **Critical** |
| 6 | Tanggal bayar salah | 🔴 Confirmed | **High** |
| 7 | Pembayaran BUG (multi) | 🔴 Confirmed | **Critical** |
| 8 | Paket belum fix | 🟡 Partial + Bug | **Medium** |
| 9 | Hari di-fix kan | 🟡 Perlu klarifikasi | **Low** |

> [!IMPORTANT]
> **Issue #5 dan #7 adalah yang paling kritis** karena bisa menyebabkan masalah finansial (duplikasi pembayaran, callback Midtrans gagal karena CSRF). Sebaiknya diprioritaskan duluan.

> [!WARNING]
> Field `durasi_pertemuan` yang dirujuk di view paket **tidak ada di database** (issue #8) — ini akan menyebabkan data kosong di tampilan siswa.
