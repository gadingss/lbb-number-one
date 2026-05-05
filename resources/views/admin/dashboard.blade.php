@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Welcome Header -->
<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-on-background tracking-tight">Dashboard Admin</h2>
        <p class="text-on-surface-variant font-medium">Selamat datang kembali, Administrator. Berikut aktivitas di LBB hari ini.</p>
    </div>
    <div class="flex gap-3">
        <button class="flex items-center gap-2 px-4 py-2 bg-surface-container-lowest text-on-surface-variant font-semibold rounded-xl hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined text-lg" data-icon="download">download</span>
            Ekspor PDF
        </button>
        <button class="flex items-center gap-2 px-4 py-2 bg-surface-container-lowest text-on-surface-variant font-semibold rounded-xl hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined text-lg" data-icon="calendar_today">calendar_today</span>
            {{ date('M Y') }}
        </button>
    </div>
</div>

<!-- Summary Cards (The "Atelier" Bento) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Students -->
    <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-primary/10 rounded-xl text-primary">
                <span class="material-symbols-outlined" data-icon="group">group</span>
            </div>
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Terbaru</span>
        </div>
        <p class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Total Siswa</p>
        <h3 class="text-3xl font-extrabold text-on-background mt-1">{{ number_format($totalSiswa) }}</h3>
    </div>

    <!-- Total Tutors -->
    <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-secondary/10 rounded-xl text-secondary">
                <span class="material-symbols-outlined" data-icon="history_edu">history_edu</span>
            </div>
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Aktif</span>
        </div>
        <p class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Tutor Aktif</p>
        <h3 class="text-3xl font-extrabold text-on-background mt-1">{{ number_format($totalTutor) }}</h3>
    </div>

    <!-- Active Packages -->
    <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-tertiary/10 rounded-xl text-tertiary">
                <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
            </div>
            <span class="text-xs font-bold text-primary-container bg-primary-fixed/30 px-2 py-1 rounded-full">Tersedia</span>
        </div>
        <p class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Paket Aktif</p>
        <h3 class="text-3xl font-extrabold text-on-background mt-1">{{ number_format($totalPaket) }}</h3>
    </div>

    <!-- Monthly Revenue -->
    <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-primary-container/10 rounded-xl text-primary-container">
                <span class="material-symbols-outlined" data-icon="payments">payments</span>
            </div>
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Bulan Ini</span>
        </div>
        <p class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Pendapatan Bulanan</p>
        <h3 class="text-3xl font-extrabold text-on-background mt-1">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- Charts & Main Analytics Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <!-- Monthly Payment Trends Chart -->
    <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-3xl shadow-sm border border-outline-variant/10 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h3 class="text-xl font-bold text-on-background">Tren Pembayaran Bulanan</h3>
                <p class="text-sm text-on-surface-variant">Pertumbuhan pendapatan selama 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-primary rounded-full"></span> Pendapatan
                </div>
            </div>
        </div>

        <!-- Visual Graph Blocks -->
        <div class="relative h-64 flex items-end justify-between gap-4 mt-auto">
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                <div class="w-full border-t border-slate-100 h-px"></div>
                <div class="w-full border-t border-slate-100 h-px"></div>
                <div class="w-full border-t border-slate-100 h-px"></div>
                <div class="w-full border-t border-slate-100 h-px"></div>
            </div>
            
            @php $isLast = count($paymentTrends) - 1; @endphp
            @foreach($paymentTrends as $index => $trend)
                <div class="flex-1 {{ $index == $isLast ? 'bg-primary' : 'bg-primary/20 hover:bg-primary/30 transition-all' }} rounded-t-lg relative group" style="height: {{ $trend['percentage'] }}%;">
                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 bg-primary rounded-full border-2 border-white {{ $index == $isLast ? 'shadow-2xl w-6 h-6 -top-3 border-4' : '' }}"></div>
                    <p class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs font-bold {{ $index == $isLast ? 'text-primary' : 'text-slate-400' }}">{{ $trend['month'] }}</p>
                    
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-on-background text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                        Rp {{ number_format($trend['total'] / 1000, 0, ',', '.') }}k
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- High Impact Tutors Section -->
    <div class="bg-surface-container-low p-8 rounded-3xl">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-bold text-on-background">Tutor Unggulan</h3>
            <a href="{{ route('admin.tutor.index') }}" class="text-primary text-sm font-bold hover:underline">Lihat Semua</a>
        </div>
        
        <div class="space-y-6">
            @forelse($eliteTutors as $tutor)
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-secondary-container flex items-center justify-center text-on-secondary-container font-black text-xl ring-2 ring-transparent group-hover:ring-primary/20 transition-all">
                            {{ substr($tutor->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-on-background">{{ $tutor->user->name }}</p>
                            <p class="text-xs text-on-surface-variant font-medium">{{ $tutor->jadwals_count }} Sesi Diberikan</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-primary">Top</p>
                        <div class="flex text-amber-400 scale-75 origin-right">
                            <span class="material-symbols-outlined" data-weight="fill" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada data tutor unggulan.</p>
            @endforelse
        </div>
        
        <div class="mt-10 p-6 bg-gradient-to-br from-primary-container to-primary rounded-2xl text-white">
            <p class="text-xs font-bold uppercase tracking-widest opacity-80 mb-1">Info Sistem</p>
            <p class="text-sm font-medium leading-relaxed">Sistem berjalan dengan stabil. Pastikan jadwal kelas dan absensi tutor terus terupdate.</p>
        </div>
    </div>
</div>

<!-- Recent Academic Activity Section -->
<div class="bg-surface-container-lowest p-8 rounded-3xl shadow-sm border border-outline-variant/10">
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-xl font-bold text-on-background">Aktivitas Akademik Terbaru</h3>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed text-xs font-bold rounded-full">Absensi Kelas</span>
        </div>
    </div>
    
    <div class="overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold border-b border-surface-variant">
                    <th class="pb-4">Tanggal</th>
                    <th class="pb-4">Siswa</th>
                    <th class="pb-4">Mata Pelajaran</th>
                    <th class="pb-4">Tutor</th>
                    <th class="pb-4">Kehadiran</th>
                    <th class="pb-4 text-right">Konfirmasi</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium">
                @forelse($recentActivities as $activity)
                    <tr class="hover:bg-surface-container-low transition-colors group border-b border-outline-variant/10 last:border-0">
                        <td class="py-4 font-mono text-slate-500">{{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}</td>
                        <td class="py-4 font-bold text-on-background">{{ $activity->siswa->user->name ?? '-' }}</td>
                        <td class="py-4 text-on-surface-variant">{{ $activity->jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                        <td class="py-4 text-on-surface-variant">{{ $activity->tutor->user->name ?? '-' }}</td>
                        <td class="py-4">
                            @if($activity->status == 'hadir')
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-[11px] font-bold">Hadir</span>
                            @elseif($activity->status == 'izin')
                                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-[11px] font-bold">Izin</span>
                            @else
                                <span class="bg-error-container text-on-error-container px-3 py-1 rounded-full text-[11px] font-bold">Alpha</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            @if($activity->konfirmasi_siswa == 'pending')
                                <span class="text-xs font-bold text-slate-400">Menunggu Siswa</span>
                            @elseif($activity->konfirmasi_siswa == 'hadir')
                                <span class="text-xs font-bold text-emerald-600">Dikonfirmasi</span>
                            @else
                                <span class="text-xs font-bold text-error">Ditolak Siswa</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-on-surface-variant">Belum ada aktivitas akademik yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-8 flex justify-center">
        <a href="{{ route('admin.absensi.index') }}" class="text-sm font-bold text-primary hover:bg-primary/5 px-6 py-2 rounded-xl transition-all">Lihat Catatan Aktivitas Lengkap</a>
    </div>
</div>
@endsection