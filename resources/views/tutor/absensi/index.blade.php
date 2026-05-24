@extends('layouts.tutor')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">Riwayat Absensi</h2>
            <p class="text-on-surface-variant font-medium mt-1">Kelola dan lihat kembali rekam jejak pertemuan dengan siswa.</p>
        </div>
        <a href="{{ route('tutor.absensi.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-on-primary rounded-full font-bold shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">add</span>
            Catat Pertemuan Baru
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-surface-container-lowest rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden border border-outline-variant/20">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead class="bg-surface-container-high/50 border-b border-outline-variant/20">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">No</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Tanggal & Jam</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Siswa</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Hasil Pembelajaran</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/15">
                    @forelse($absensis as $key => $absensi)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-6 py-5 font-medium text-sm text-on-surface-variant">{{ $key + 1 }}</td>
                        <td class="px-6 py-5">
                            <p class="font-bold text-on-surface">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</p>
                            <p class="text-xs text-on-surface-variant">{{ \Carbon\Carbon::parse($absensi->jam_absen)->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    {{ substr($absensi->siswa->user->name, 0, 1) }}
                                </div>
                                <p class="font-bold text-sm text-on-surface">{{ $absensi->siswa->user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 bg-surface-container border border-outline-variant/30 rounded-lg text-xs font-bold text-on-surface-variant">
                                {{ $absensi->jadwal->mataPelajaran->nama_mapel }}
                            </span>
                        </td>
                        <td class="px-6 py-5 max-w-[200px]">
                            <p class="text-xs text-on-surface-variant line-clamp-2" title="{{ $absensi->hasil_pertemuan }}">
                                {{ $absensi->hasil_pertemuan ?? '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-5">
                            @if($absensi->status == 'hadir')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                    Hadir
                                </span>
                            @elseif($absensi->status == 'izin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    Izin
                                </span>
                            @elseif($absensi->status == 'tidak_hadir' || $absensi->status == 'alpha')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-error-container text-on-error-container text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                    Alpha
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-variant text-on-surface-variant text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                    {{ $absensi->status }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">event_busy</span>
                            Belum ada riwayat absensi yang dicatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
