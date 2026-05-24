@extends('layouts.app')

@section('title', 'Laporan Kehadiran')

@section('content')
{{-- Header Section --}}
<div class="flex items-end justify-between mb-10">
    <div>
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2 tracking-widest uppercase">
            <span>Analitik</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary">Laporan Kehadiran</span>
        </nav>
        <h2 class="text-4xl font-extrabold text-on-background tracking-tight font-headline">LBB Number One</h2>
        <p class="text-on-surface-variant mt-1 text-lg">Les Bimbel Private</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.absensi.rekap') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-surface-container-highest text-on-surface-variant rounded-xl font-bold text-sm hover:bg-surface-dim transition-colors">
            <span class="material-symbols-outlined text-[18px]">bar_chart</span>
            Rekap Tutor
        </a>
        <a href="{{ route('admin.absensi.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Catat Absensi
        </a>
    </div>
</div>

{{-- Success Alert --}}
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-semibold text-sm">{{ session('success') }}</span>
</div>
@endif

{{-- Metric Cards Grid --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
    {{-- Overall Attendance --}}
    <div class="bg-surface-container-lowest p-8 rounded-2xl border border-transparent hover:border-primary/10 transition-all duration-300 group">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-primary/5 rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                <span class="material-symbols-outlined text-3xl">analytics</span>
            </div>
            @if($persentaseKehadiran >= 90)
            <div class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg text-xs font-bold">
                <span class="material-symbols-outlined text-[16px]">trending_up</span>
                Baik
            </div>
            @else
            <div class="flex items-center gap-1 text-amber-600 bg-amber-50 px-2 py-1 rounded-lg text-xs font-bold">
                <span class="material-symbols-outlined text-[16px]">trending_down</span>
                Perlu Perhatian
            </div>
            @endif
        </div>
        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Kehadiran Keseluruhan</p>
        <h3 class="text-5xl font-black text-on-background tracking-tighter font-headline">{{ $persentaseKehadiran }}%</h3>
        <div class="mt-6 h-2 w-full bg-surface-container rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-700" style="width: {{ $persentaseKehadiran }}%"></div>
        </div>
    </div>

    {{-- Active Sessions --}}
    <div class="bg-surface-container-lowest p-8 rounded-2xl border border-transparent hover:border-secondary/10 transition-all duration-300 group">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-secondary/5 rounded-xl text-secondary group-hover:bg-secondary group-hover:text-white transition-colors duration-300">
                <span class="material-symbols-outlined text-3xl">schedule</span>
            </div>
            <p class="text-xs font-bold text-slate-400">Minggu Ini</p>
        </div>
        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Sesi Aktif</p>
        <h3 class="text-5xl font-black text-on-background tracking-tighter font-headline">{{ str_pad($sesiAktifMingguIni, 2, '0', STR_PAD_LEFT) }}</h3>
        <p class="mt-4 text-sm text-on-surface-variant">Di seluruh <span class="font-bold text-primary">{{ $jumlahMapel }}</span> kategori mata pelajaran</p>
    </div>

    {{-- Alerts --}}
    <div class="bg-surface-container-lowest p-8 rounded-2xl border border-transparent hover:border-tertiary/10 transition-all duration-300 group">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-tertiary/5 rounded-xl text-tertiary group-hover:bg-tertiary group-hover:text-white transition-colors duration-300">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            @if($peringatan > 0)
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-tertiary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-tertiary"></span>
            </span>
            @endif
        </div>
        <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Peringatan</p>
        <h3 class="text-5xl font-black text-on-background tracking-tighter font-headline">{{ str_pad($peringatan, 2, '0', STR_PAD_LEFT) }}</h3>
        <p class="mt-4 text-sm text-tertiary font-medium">
            {{ $totalAlpha }} alpha & {{ $totalTidakHadir }} tidak hadir
        </p>
    </div>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.absensi.index') }}">
<div class="bg-surface-container-low p-6 rounded-2xl mb-8 flex flex-wrap items-center gap-6">
    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Rentang Tanggal</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
            </span>
            <select name="rentang" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border-none rounded-xl text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary/20 appearance-none">
                <option value="">Semua Waktu</option>
                <option value="7" {{ request('rentang') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ request('rentang') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="bulan_ini" {{ request('rentang') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
            </select>
        </div>
    </div>

    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Pengajar</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none">
                <span class="material-symbols-outlined text-[18px]">person</span>
            </span>
            <select name="tutor_id" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border-none rounded-xl text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary/20 appearance-none">
                <option value="">Semua Pengajar</option>
                @foreach($tutors as $tutor)
                    <option value="{{ $tutor->id }}" {{ request('tutor_id') == $tutor->id ? 'selected' : '' }}>
                        {{ $tutor->user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Mata Pelajaran</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none">
                <span class="material-symbols-outlined text-[18px]">book</span>
            </span>
            <select name="mata_pelajaran_id" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border-none rounded-xl text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary/20 appearance-none">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($mapelList as $mapel)
                    <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex items-end h-full mt-auto">
        <button type="submit" class="bg-primary-container/10 text-primary p-3 rounded-xl hover:bg-primary-container hover:text-white transition-all duration-200">
            <span class="material-symbols-outlined">filter_list</span>
        </button>
    </div>
</div>
</form>

{{-- Detailed Records Table --}}
<div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
    <div class="px-8 py-6 flex justify-between items-center border-b border-surface-container">
        <h3 class="text-xl font-bold text-on-background font-headline">Catatan Rinci</h3>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-500 font-medium">
                Menampilkan {{ $absensis->firstItem() ?? 0 }}-{{ $absensis->lastItem() ?? 0 }} dari {{ $absensis->total() }} entri
            </span>
            @if($absensis->hasPages())
            <div class="flex gap-1">
                @if($absensis->previousPageUrl())
                <a href="{{ $absensis->previousPageUrl() }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
                @endif
                @if($absensis->nextPageUrl())
                <a href="{{ $absensis->nextPageUrl() }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low">
                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Pengajar</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Siswa</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Mata Pelajaran</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Hasil Pembelajaran</th>
                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container/30">
                @forelse($absensis as $absensi)
                <tr class="hover:bg-surface-container-low transition-colors duration-150 group">
                    <td class="px-8 py-5 text-sm font-bold text-on-surface">
                        {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            @php
                                $tutorName = $absensi->tutor->user->name;
                                $initials = collect(explode(' ', $tutorName))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                                $colors = ['bg-blue-100 text-blue-700', 'bg-slate-100 text-slate-700', 'bg-indigo-100 text-indigo-700', 'bg-purple-100 text-purple-700', 'bg-cyan-100 text-cyan-700'];
                                $colorIdx = crc32($tutorName) % count($colors);
                            @endphp
                            <div class="w-8 h-8 rounded-full {{ $colors[$colorIdx] }} flex items-center justify-center text-xs font-bold">
                                {{ $initials }}
                            </div>
                            <span class="text-sm font-semibold text-on-surface-variant">{{ $tutorName }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-medium text-on-surface">{{ $absensi->siswa->user->name }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed rounded-full text-xs font-bold">
                            {{ $absensi->jadwal->mataPelajaran->nama_mapel }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        @if($absensi->status == 'hadir')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[11px] font-black uppercase tracking-wider">Hadir</span>
                        @elseif($absensi->status == 'izin')
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[11px] font-black uppercase tracking-wider">Izin</span>
                        @elseif($absensi->status == 'tidak_hadir')
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[11px] font-black uppercase tracking-wider">Tidak Hadir</span>
                        @else
                            <span class="px-3 py-1 bg-error-container text-on-error-container rounded-full text-[11px] font-black uppercase tracking-wider">Alpha</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        @if($absensi->hasil_pertemuan)
                            <span class="text-sm text-slate-600 line-clamp-2" title="{{ $absensi->hasil_pertemuan }}">{{ $absensi->hasil_pertemuan }}</span>
                        @else
                            <span class="text-sm text-slate-300 italic">—</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.absensi.edit', $absensi->id) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container hover:bg-primary-fixed hover:text-primary transition-colors text-slate-500" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <form action="{{ route('admin.absensi.destroy', $absensi->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container hover:bg-error-container hover:text-error transition-colors text-slate-500" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-5xl text-slate-300">event_busy</span>
                            <p class="text-slate-400 font-semibold">Tidak ada data absensi</p>
                            <a href="{{ route('admin.absensi.create') }}"
                               class="text-primary font-bold text-sm hover:underline">+ Catat Absensi Baru</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($absensis->hasPages())
    <div class="px-8 py-6 bg-surface-container-low flex justify-center">
        <nav class="flex gap-2">
            {{-- Previous --}}
            @if($absensis->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest text-slate-300 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </span>
            @else
                <a href="{{ $absensis->previousPageUrl() }}"
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest text-slate-400 hover:text-primary transition-colors border border-transparent hover:border-primary/20">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach($absensis->getUrlRange(1, $absensis->lastPage()) as $page => $url)
                @if($page == $absensis->currentPage())
                    <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary text-white font-bold">{{ $page }}</span>
                @elseif($page <= 3 || $page == $absensis->lastPage() || abs($page - $absensis->currentPage()) <= 1)
                    <a href="{{ $url }}"
                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest text-slate-600 font-bold hover:bg-white transition-colors">{{ $page }}</a>
                @elseif($page == 4 && $absensis->lastPage() > 5)
                    <span class="w-10 h-10 flex items-end justify-center pb-2 text-slate-400">...</span>
                @endif
            @endforeach

            {{-- Next --}}
            @if($absensis->hasMorePages())
                <a href="{{ $absensis->nextPageUrl() }}"
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest text-slate-400 hover:text-primary transition-colors border border-transparent hover:border-primary/20">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            @else
                <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container-lowest text-slate-300 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_right</span>
                </span>
            @endif
        </nav>
    </div>
    @endif
</div>

{{-- Secondary Analysis Section --}}
<div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Subject Distribution --}}
    <div class="bg-surface-container-lowest p-8 rounded-2xl">
        <h4 class="text-lg font-bold text-on-background mb-6 font-headline">Distribusi Mata Pelajaran</h4>
        <div class="space-y-6">
            @php
                $barColors = ['text-primary bg-primary', 'text-secondary bg-secondary', 'text-tertiary bg-tertiary', 'text-emerald-600 bg-emerald-500', 'text-purple-600 bg-purple-500'];
            @endphp
            @forelse($distribusiMapel->take(5) as $idx => $mapel)
            <div>
                <div class="flex justify-between text-sm font-bold mb-2">
                    <span class="text-slate-600">{{ $mapel['nama'] }}</span>
                    <span class="{{ explode(' ', $barColors[$idx % count($barColors)])[0] }}">{{ $mapel['persentase'] }}%</span>
                </div>
                <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                    <div class="h-full {{ explode(' ', $barColors[$idx % count($barColors)])[1] }} rounded-full transition-all duration-700" style="width: {{ $mapel['persentase'] }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-slate-400 text-sm italic">Belum ada data distribusi mata pelajaran.</p>
            @endforelse
        </div>
    </div>

    {{-- Quick Report Summary --}}
    <div class="bg-surface-container-lowest p-8 rounded-2xl flex flex-col justify-between">
        <div>
            <h4 class="text-lg font-bold text-on-background mb-2 font-headline">Ringkasan Laporan Cepat</h4>
            <p class="text-sm text-on-surface-variant">
                Total kehadiran <span class="text-emerald-600 font-bold">{{ $totalHadir }}</span> dari {{ $totalAbsensi }} sesi tercatat.
                Ketidakhadiran tanpa alasan (alpha) sebanyak <span class="font-bold">{{ $totalAlpha }}</span> sesi.
            </p>

            {{-- Status breakdown --}}
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-xl">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Hadir</p>
                        <p class="text-lg font-black text-emerald-700">{{ $totalHadir }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-xl">
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Izin</p>
                        <p class="text-lg font-black text-amber-700">{{ $totalIzin }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Tidak Hadir</p>
                        <p class="text-lg font-black text-red-700">{{ $totalTidakHadir }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                    <div class="w-3 h-3 rounded-full bg-slate-500"></div>
                    <div>
                        <p class="text-xs text-slate-500 font-semibold">Alpha</p>
                        <p class="text-lg font-black text-slate-700">{{ $totalAlpha }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 p-4 bg-primary-fixed rounded-xl border border-primary/10">
            <div class="flex items-start gap-4">
                <div class="p-2 bg-primary rounded-lg text-white">
                    <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-primary-fixed uppercase tracking-wider">Wawasan</p>
                    <p class="text-sm text-on-primary-fixed-variant mt-1">
                        @if($persentaseKehadiran >= 90)
                            Tingkat kehadiran sangat baik! Pertahankan kualitas pembelajaran untuk memastikan hasil optimal bagi siswa.
                        @elseif($persentaseKehadiran >= 75)
                            Tingkat kehadiran cukup baik. Perhatikan siswa dengan catatan alpha untuk meningkatkan keterlibatan.
                        @else
                            Tingkat kehadiran perlu ditingkatkan. Lakukan evaluasi jadwal dan komunikasi dengan siswa & tutor.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
