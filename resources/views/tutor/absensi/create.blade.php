@extends('layouts.tutor')

@section('title', 'Catat Pertemuan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">Catat Pertemuan Baru</h2>
            <p class="text-on-surface-variant font-medium mt-1">Laporkan progres belajar siswa dengan akurat.</p>
        </div>
        <a href="{{ route('tutor.absensi.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-on-surface rounded-full font-bold transition-colors w-fit">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Riwayat
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-surface-container-lowest rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden border border-outline-variant/20">
        <form action="{{ route('tutor.absensi.store') }}" method="POST">
            @csrf
            
            <!-- Hero Section form -->
            <div class="bg-primary-fixed/30 p-6 sm:p-8 border-b border-primary/10">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined">how_to_reg</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface">Detail Pertemuan</h3>
                        <p class="text-on-surface-variant text-sm mt-1">Pilih jadwal dan tentukan waktu pelaksanaan.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 space-y-8">
                <!-- Row 1: Jadwal -->
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-primary">calendar_month</span>
                        Pilih Jadwal Siswa
                    </label>
                    <div class="relative">
                        <select name="jadwal_id" id="jadwal_id" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3.5 appearance-none focus:ring-2 focus:ring-primary font-medium text-on-surface" required onchange="updateTanggal()">
                            <option value="">-- Pilih Jadwal --</option>
                            
                            <optgroup label="Jadwal Pengganti (Reschedule)">
                                @foreach($jadwalPenggantis as $jp)
                                    <option value="pengganti_{{ $jp->id }}" data-tanggal="{{ $jp->tanggal_pengganti }}" data-jam="{{ \Carbon\Carbon::parse($jp->jadwal->jam_mulai)->format('H:i') }}" {{ $selectedJadwal == 'pengganti_'.$jp->id ? 'selected' : '' }}>
                                        [{{ $jp->jadwal->mataPelajaran->nama_mapel }}] {{ $jp->jadwal->siswa->user->name }} - Pengganti ({{ \Carbon\Carbon::parse($jp->tanggal_pengganti)->format('d M') }})
                                    </option>
                                @endforeach
                            </optgroup>
                            
                            <optgroup label="Jadwal Rutin">
                                @foreach($jadwals as $jadwal)
                                    <option value="rutin_{{ $jadwal->id }}" data-tanggal="{{ date('Y-m-d') }}" data-jam="{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}" {{ $selectedJadwal == 'rutin_'.$jadwal->id ? 'selected' : '' }}>
                                        [{{ $jadwal->mataPelajaran->nama_mapel }}] {{ $jadwal->siswa->user->name }} ({{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-on-surface-variant">
                            <span class="material-symbols-outlined">expand_more</span>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Tanggal & Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-primary">event</span>
                            Tanggal Pelaksanaan
                        </label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary font-medium text-on-surface" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-primary">schedule</span>
                            Jam Pelaksanaan
                        </label>
                        <input type="time" name="jam_absen" id="jam_absen" value="{{ date('H:i') }}" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary font-medium text-on-surface" required>
                    </div>
                </div>

                <!-- Row 3: Status -->
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-primary">fact_check</span>
                        Status Kehadiran Siswa
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer relative">
                            <input type="radio" name="status" value="hadir" class="peer sr-only" required checked>
                            <div class="rounded-xl border-2 border-outline-variant/30 py-3 px-4 text-center peer-checked:border-primary peer-checked:bg-primary-fixed hover:bg-surface-container-high transition-all">
                                <span class="material-symbols-outlined block text-2xl mb-1 text-primary">check_circle</span>
                                <span class="font-bold text-sm text-on-surface">Hadir</span>
                            </div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="status" value="izin" class="peer sr-only" required>
                            <div class="rounded-xl border-2 border-outline-variant/30 py-3 px-4 text-center peer-checked:border-tertiary peer-checked:bg-tertiary-fixed hover:bg-surface-container-high transition-all">
                                <span class="material-symbols-outlined block text-2xl mb-1 text-tertiary">sick</span>
                                <span class="font-bold text-sm text-on-surface">Izin/Sakit</span>
                            </div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="status" value="alpha" class="peer sr-only" required>
                            <div class="rounded-xl border-2 border-outline-variant/30 py-3 px-4 text-center peer-checked:border-error peer-checked:bg-error-container hover:bg-surface-container-high transition-all">
                                <span class="material-symbols-outlined block text-2xl mb-1 text-error">cancel</span>
                                <span class="font-bold text-sm text-on-surface">Alpha</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Row 4: Hasil Pembelajaran -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-primary">school</span>
                        Hasil Pembelajaran
                    </label>
                    <p class="text-xs text-on-surface-variant mb-2">Akan ditampilkan ke siswa. Apa saja yang dipelajari hari ini?</p>
                    <textarea name="hasil_pertemuan" rows="4" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary font-medium text-on-surface resize-none" placeholder="Materi yang dibahas hari ini..."></textarea>
                </div>
            </div>

            <!-- Footer / Action -->
            <div class="p-6 sm:p-8 bg-surface-container-lowest border-t border-outline-variant/20 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a href="{{ route('tutor.absensi.index') }}" class="px-6 py-3 text-center text-on-surface font-bold hover:bg-surface-container-high rounded-full transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary/90 text-on-primary font-bold rounded-full shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateTanggal() {
        const select = document.getElementById('jadwal_id');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption) {
            if (selectedOption.dataset.tanggal) {
                document.getElementById('tanggal').value = selectedOption.dataset.tanggal;
            }
            if (selectedOption.dataset.jam) {
                document.getElementById('jam_absen').value = selectedOption.dataset.jam;
            }
        }
    }
    
    // Panggil saat load halaman, jika sudah ada yang ter-select
    document.addEventListener('DOMContentLoaded', updateTanggal);
</script>
@endsection
