@extends('layouts.tutor')

@section('title', 'Dashboard')

@section('content')

<!-- Greeting & Stats Section -->
<div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
    <div>
        <h2 class="font-headline font-bold text-4xl text-on-surface tracking-tight">Dashboard Tutor</h2>
        <p class="text-on-surface-variant mt-2">Selamat datang, <span class="text-primary font-semibold">{{ auth()->user()->name }}</span>! Hari ini adalah {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}.</p>
    </div>
    <div class="bg-surface-container-low px-4 py-2 rounded-lg flex items-center gap-2">
        <span class="material-symbols-outlined text-primary" data-icon="schedule">schedule</span>
        <span class="text-sm font-medium text-on-surface-variant">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</span>
    </div>
</div>

<!-- Bento Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Stat 1 -->
    <div class="bg-surface-container-lowest p-6 rounded-xl ambient-shadow flex flex-col justify-between border-l-4 border-primary">
        <div>
            <span class="text-[10px] font-bold text-outline tracking-widest uppercase mb-1 block">Total Pertemuan</span>
            <div class="flex items-end gap-2">
                <h3 class="font-headline font-extrabold text-5xl text-on-surface">{{ $totalPertemuan ?? 0 }}</h3>
                <span class="text-on-surface-variant font-medium pb-1.5">Sesi</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-xs text-primary font-semibold bg-primary-fixed/30 px-3 py-1.5 rounded-full w-fit">
            <span class="material-symbols-outlined text-sm" data-icon="trending_up">trending_up</span>
            <span>All Time</span>
        </div>
    </div>
    
    <!-- Stat 2 -->
    <div class="bg-surface-container-lowest p-6 rounded-xl ambient-shadow flex flex-col justify-between border-l-4 border-secondary">
        <div>
            <span class="text-[10px] font-bold text-outline tracking-widest uppercase mb-1 block">Bulan Ini</span>
            <h3 class="font-headline font-extrabold text-5xl text-on-surface">{{ $pertemuanBulanIni ?? 0 }}</h3>
        </div>
        <div class="mt-4 flex items-center gap-2 text-xs text-secondary font-semibold bg-secondary-container/30 px-3 py-1.5 rounded-full w-fit">
            <span class="material-symbols-outlined text-sm" data-icon="checklist">checklist</span>
            <span>On track</span>
        </div>
    </div>
    
    <!-- Stat 3 -->
    <div class="bg-surface-container-lowest p-6 rounded-xl ambient-shadow flex flex-col justify-between border-l-4 border-tertiary">
        <div>
            <span class="text-[10px] font-bold text-outline tracking-widest uppercase mb-1 block">Jadwal Total</span>
            <h3 class="font-headline font-extrabold text-5xl text-on-surface">{{ $semuaJadwal->count() ?? 0 }}</h3>
        </div>
        <div class="mt-4 flex items-center gap-2 text-xs text-tertiary font-semibold bg-tertiary-fixed/30 px-3 py-1.5 rounded-full w-fit">
            <span class="material-symbols-outlined text-sm" data-icon="event">event</span>
            <span>Semua Sesi</span>
        </div>
    </div>
    
    <!-- Stat 4 -->
    <div class="bg-surface-container-lowest p-6 rounded-xl ambient-shadow flex flex-col justify-between border-l-4 border-primary-container">
        <div>
            <span class="text-[10px] font-bold text-outline tracking-widest uppercase mb-1 block">Mata Pelajaran</span>
            <h3 class="font-headline font-extrabold text-5xl text-on-surface">{{ $semuaJadwal->pluck('mataPelajaran.nama_mapel')->unique()->count() ?? 0 }}</h3>
        </div>
        <div class="mt-4 flex items-center gap-2 text-xs text-primary-container font-semibold bg-surface-container-high px-3 py-1.5 rounded-full w-fit">
            <span class="material-symbols-outlined text-sm" data-icon="auto_stories">auto_stories</span>
            <span>Mapel Diampu</span>
        </div>
    </div>
</div>

<!-- Focus Content Section: Asymmetric Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <!-- Left: Next Session Highlight -->
    <div class="lg:col-span-5 flex flex-col gap-6">
        <h4 class="font-headline font-bold text-xl flex items-center gap-3">
            <span class="w-1.5 h-6 bg-primary rounded-full"></span>
            Jadwal Hari Ini
        </h4>
        
        @if($sesiBerikutnya)
        <div class="bg-surface-container-lowest rounded-xl overflow-hidden ambient-shadow flex flex-col h-full">
            <div class="gradient-primary p-8 text-on-primary">
                <div class="flex justify-between items-start mb-6">
                    <span class="bg-white/20 text-xs font-bold px-3 py-1 rounded-full backdrop-blur-md uppercase tracking-widest">Sesi Berikutnya</span>
                    <span class="material-symbols-outlined" data-icon="stars">stars</span>
                </div>
                <h5 class="font-headline font-extrabold text-3xl mb-2">{{ $sesiBerikutnya->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</h5>
                <p class="text-on-primary-container/80 text-sm">Persiapan Mengajar</p>
            </div>
            
            <div class="p-8 space-y-6 bg-surface-container-lowest flex-grow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" data-icon="alarm">alarm</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-outline tracking-widest uppercase">Waktu</p>
                        <p class="font-semibold text-on-surface">{{ \Carbon\Carbon::parse($sesiBerikutnya->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesiBerikutnya->jam_selesai)->format('H:i') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" data-icon="location_on">location_on</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-outline tracking-widest uppercase">Lokasi</p>
                        <p class="font-semibold text-on-surface">TBA (Hubungi Siswa)</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" data-icon="person">person</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-outline tracking-widest uppercase">Siswa</p>
                        <p class="font-semibold text-on-surface">{{ $sesiBerikutnya->siswa->user->name ?? 'Belum Ditentukan' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-surface-container-low flex gap-3">
                <a href="{{ route('tutor.absensi.index') }}" class="flex-1 gradient-primary text-on-primary font-bold py-3 rounded-lg flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform">
                    <span class="material-symbols-outlined text-sm" data-icon="history_edu">history_edu</span>
                    <span>Absensi</span>
                </a>
            </div>
        </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl ambient-shadow p-10 flex flex-col items-center justify-center h-full border border-outline-variant/20 text-center">
            <div class="w-20 h-20 bg-surface-container-low rounded-full flex items-center justify-center text-on-surface-variant mb-6">
                <span class="material-symbols-outlined text-4xl" data-icon="event_busy">event_busy</span>
            </div>
            <h5 class="font-headline font-bold text-xl text-on-surface mb-2">Tidak Ada Jadwal</h5>
            <p class="text-on-surface-variant">Anda tidak memiliki jadwal mengajar pada hari ini. Nikmati waktu istirahat Anda!</p>
        </div>
        @endif
    </div>
    
    <!-- Right: Schedule Table -->
    <div class="lg:col-span-7 flex flex-col gap-6">
        <div class="flex justify-between items-center">
            <h4 class="font-headline font-bold text-xl flex items-center gap-3">
                <span class="w-1.5 h-6 bg-secondary rounded-full"></span>
                Semua Jadwal Mengajar
            </h4>
        </div>
        
        <div class="bg-surface-container-lowest rounded-xl ambient-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-high">
                            <th class="px-6 py-4 font-label text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Hari</th>
                            <th class="px-6 py-4 font-label text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Mata Pelajaran</th>
                            <th class="px-6 py-4 font-label text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Jam</th>
                            <th class="px-6 py-4 font-label text-[10px] font-bold uppercase tracking-wider text-on-surface-variant text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaJadwal as $jadwal)
                        <tr class="group hover:bg-surface-container-low transition-colors {{ !$loop->first ? 'border-t border-outline-variant/10' : '' }}">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-on-surface">{{ $jadwal->hari }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full {{ $loop->iteration % 2 == 0 ? 'bg-secondary' : 'bg-primary' }}"></div>
                                    <p class="font-medium">{{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm text-on-surface-variant">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('tutor.jadwal.index') }}" class="text-primary hover:text-primary-fixed-variant font-bold text-xs uppercase tracking-wide">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <p class="text-on-surface-variant font-medium">Belum ada jadwal yang ditetapkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Additional Context Card -->
        <div class="bg-primary-fixed/20 p-6 rounded-xl border border-primary/10 flex items-center gap-6 mt-4">
            <div class="w-16 h-16 rounded-full bg-surface-container-lowest flex items-center justify-center text-primary ambient-shadow flex-shrink-0">
                <span class="material-symbols-outlined text-3xl" data-icon="lightbulb">lightbulb</span>
            </div>
            <div class="flex-grow">
                <h5 class="font-headline font-bold text-lg">Tips Mengajar</h5>
                <p class="text-sm text-on-surface-variant">Pastikan Anda selalu memperbarui modul dan menyiapkan materi terbaik untuk siswa. Komunikasi yang baik adalah kunci kesuksesan belajar.</p>
            </div>
        </div>
    </div>
</div>

@endsection
