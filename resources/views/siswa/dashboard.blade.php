@extends('layouts.siswa')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">
    <!-- Welcome Header -->
    <section>
        <h3 class="text-2xl sm:text-display-lg font-headline text-on-surface leading-tight tracking-tight">
            Selamat datang kembali, <span class="text-primary">{{ explode(' ', auth()->user()->name)[0] }}</span>!
        </h3>
        <p class="text-on-surface-variant mt-2 font-medium">Siap untuk melanjutkan petualangan belajarmu hari ini?</p>
    </section>

    <!-- Hero Active Package Cards -->
    @if(count($paketAktifList) > 0)
        <div class="space-y-6">
            <h4 class="text-xl font-bold text-on-surface">Paket Aktif Anda ({{ count($paketAktifList) }})</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($paketAktifList as $paket)
                <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-primary-container p-6 text-on-primary-container shadow-xl">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <span class="px-3 py-1 rounded-full bg-white/20 text-white text-[10px] font-bold tracking-widest uppercase mb-3 inline-block">ID: {{ $paket->order_id }}</span>
                            <h2 class="text-2xl font-headline font-black text-white mb-1">{{ $paket->paket->nama_paket }}</h2>
                            <p class="text-sm text-primary-fixed font-medium flex items-center gap-1.5 mb-6">
                                <span class="material-symbols-outlined text-sm">school</span> {{ $paket->paket->mataPelajaran->nama_mapel ?? 'Mata Pelajaran Umum' }}
                            </p>
                        </div>
                        
                        <div>
                            <div class="flex gap-2 mb-6">
                                <div class="bg-white/10 backdrop-blur-md px-3 py-2 rounded-xl flex-1 text-center border border-white/10">
                                    <p class="text-[9px] text-white/60 uppercase font-bold tracking-wider">Terpakai</p>
                                    <p class="text-base font-bold text-white">{{ $paket->sesi_terpakai }}</p>
                                </div>
                                <div class="bg-primary-fixed/20 backdrop-blur-md px-3 py-2 rounded-xl flex-1 text-center border border-primary-fixed/20">
                                    <p class="text-[9px] text-white uppercase font-bold tracking-wider">Sisa</p>
                                    <p class="text-base font-bold text-white">{{ $paket->sisa_sesi }}</p>
                                </div>
                                <div class="bg-white/10 backdrop-blur-md px-3 py-2 rounded-xl flex-1 text-center border border-white/10">
                                    <p class="text-[9px] text-white/60 uppercase font-bold tracking-wider">Total</p>
                                    <p class="text-base font-bold text-white">{{ $paket->paket->jumlah_pertemuan }}</p>
                                </div>
                            </div>
                            
                            @php
                                $totalSesi = $paket->paket->jumlah_pertemuan;
                                $persentase = $totalSesi > 0 ? round(($paket->sesi_terpakai / $totalSesi) * 100) : 0;
                            @endphp
                            <div class="space-y-2">
                                <div class="flex justify-between items-end">
                                    <p class="text-white text-xs font-bold">Progress</p>
                                    <p class="text-white/80 text-[10px] font-medium">{{ $persentase }}% Selesai</p>
                                </div>
                                <div class="w-full bg-white/30 rounded-full h-1.5">
                                    <div class="bg-white h-1.5 rounded-full" style="width: {{ $persentase }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
            </div>
        </div>
    @else
    <div class="bg-surface-container-highest border border-outline-variant rounded-2xl sm:rounded-[2rem] p-6 sm:p-10 mb-8 flex flex-col items-center justify-center text-center">
        <h3 class="text-xl font-headline font-bold text-on-surface mb-2">Belum Memiliki Paket Aktif</h3>
        <p class="text-on-surface-variant mb-6">Silakan pilih paket les terlebih dahulu untuk memulai pembelajaran</p>
        <a href="{{ route('siswa.paket.index') }}" class="bg-primary hover:bg-primary/90 text-on-primary font-bold px-8 py-3 rounded-xl transition-colors">
            Pilih Paket
        </a>
    </div>
    @endif

    <!-- Stats Bento Grid -->
    <section class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-surface-container-lowest p-5 sm:p-8 rounded-[1.5rem] shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <p class="text-on-surface-variant font-headline text-label-md font-bold tracking-wide uppercase mb-4">Total Pertemuan</p>
            <div class="flex items-end gap-3">
                <span class="text-3xl sm:text-5xl font-headline font-black text-primary">{{ $totalPertemuan ?? 0 }}</span>
                <span class="text-on-surface-variant font-medium pb-2 text-sm">Sesi</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-surface-container-lowest p-5 sm:p-8 rounded-[1.5rem] shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-tertiary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <p class="text-on-surface-variant font-headline text-label-md font-bold tracking-wide uppercase mb-4">Bulan Ini</p>
            <div class="flex items-end gap-3">
                <span class="text-3xl sm:text-5xl font-headline font-black text-tertiary">{{ $pertemuanBulanIni ?? 0 }}</span>
                <span class="text-on-surface-variant font-medium pb-2 text-sm">Sesi</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-surface-container-lowest p-5 sm:p-8 rounded-[1.5rem] shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <p class="text-on-surface-variant font-headline text-label-md font-bold tracking-wide uppercase mb-4">Total Pembayaran</p>
            <div class="space-y-1">
                <span class="text-xl sm:text-3xl font-headline font-black text-secondary">Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}</span>
                <p class="text-on-surface-variant font-medium text-xs">Akumulasi Seluruhnya</p>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-surface-container-lowest p-5 sm:p-8 rounded-[1.5rem] shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary-fixed-dim/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <p class="text-on-surface-variant font-headline text-label-md font-bold tracking-wide uppercase mb-4">Status Paket</p>
            <div class="flex items-center gap-3">
                <div class="w-4 h-4 rounded-full {{ $paket ? 'bg-primary animate-pulse' : 'bg-outline' }}"></div>
                <span class="text-xl sm:text-3xl font-headline font-black text-on-surface">{{ $paket ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
            @if($paket)
                <p class="text-on-surface-variant font-medium text-xs mt-3">Sedang berjalan</p>
            @endif
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-10">
        <!-- Payments Section -->
        <section class="lg:col-span-2 space-y-6">
            <div class="flex justify-between items-center px-2">
                <h4 class="text-2xl font-headline font-bold text-on-surface">Riwayat Pembayaran</h4>
                <a href="{{ route('siswa.pembayaran.index') }}" class="text-primary font-bold text-sm hover:underline">Lihat Semua Pembayaran</a>
            </div>
            
            <div class="bg-surface-container-low rounded-[1.5rem] overflow-hidden p-1">
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead class="bg-surface-container-high/50">
                            <tr>
                                <th class="px-4 sm:px-8 py-4 text-[10px] font-bold tracking-[0.1em] text-on-surface-variant uppercase">Tanggal</th>
                                <th class="px-4 sm:px-8 py-4 text-[10px] font-bold tracking-[0.1em] text-on-surface-variant uppercase">Paket</th>
                                <th class="px-4 sm:px-8 py-4 text-[10px] font-bold tracking-[0.1em] text-on-surface-variant uppercase">Jumlah</th>
                                <th class="px-4 sm:px-8 py-4 text-[10px] font-bold tracking-[0.1em] text-on-surface-variant uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/15">
                            @forelse($riwayatPembayaran as $pembayaran)
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-4 sm:px-8 py-4 sm:py-6 font-medium text-sm text-on-surface">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
                                <td class="px-4 sm:px-8 py-4 sm:py-6">
                                    <p class="font-bold text-on-surface">{{ $pembayaran->paket->nama_paket }}</p>
                                    <p class="text-xs text-on-surface-variant">Pembelian</p>
                                </td>
                                <td class="px-4 sm:px-8 py-4 sm:py-6 font-bold text-on-surface">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 sm:px-8 py-4 sm:py-6">
                                    @if($pembayaran->status == 'lunas')
                                        <span class="px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[10px] font-black uppercase tracking-wider">Lunas</span>
                                    @elseif($pembayaran->status == 'pending')
                                        <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[10px] font-black uppercase tracking-wider">Menunggu</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-error-container text-on-error-container text-[10px] font-black uppercase tracking-wider">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 sm:px-8 py-4 sm:py-6 text-center text-on-surface-variant">Belum ada riwayat pembayaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Upcoming Schedule -->
        <section class="space-y-6">
            <div class="flex justify-between items-center px-2">
                <h4 class="text-2xl font-headline font-bold text-on-surface">Jadwal Anda</h4>
                <a href="{{ route('siswa.jadwal.index') }}" class="w-8 h-8 rounded-full bg-primary-fixed/30 text-primary flex items-center justify-center hover:bg-primary-fixed transition-colors">
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($jadwalTerdekat as $jadwal)
                <!-- Schedule Item -->
                <div class="bg-surface-container-lowest p-6 rounded-[1.5rem] shadow-[0_8px_24px_-4px_rgba(13,28,46,0.04)] border-l-4 {{ $loop->iteration % 2 == 0 ? 'border-tertiary' : 'border-primary' }}">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="{{ $loop->iteration % 2 == 0 ? 'text-tertiary' : 'text-primary' }} font-bold text-sm">{{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} WIB</p>
                            <h5 class="font-headline font-bold text-lg text-on-surface mt-1">{{ $jadwal->mataPelajaran->nama_mapel }}</h5>
                        </div>
                        <span class="px-2 py-1 bg-surface-container text-on-surface-variant rounded text-[10px] font-bold uppercase">Les</span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary font-bold text-xs">
                            {{ substr($jadwal->tutor->user->name ?? 'T', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant">Tutor</p>
                            <p class="text-sm font-bold text-on-surface">{{ $jadwal->tutor->user->name ?? 'Belum Ditentukan' }}</p>
                        </div>
                        <a href="{{ route('siswa.jadwal.index') }}" class="ml-auto w-10 h-10 rounded-xl bg-surface-container-high text-on-surface-variant flex items-center justify-center hover:bg-primary-fixed transition-colors">
                            <span class="material-symbols-outlined">event</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="bg-surface-container-lowest p-6 rounded-[1.5rem] text-center text-on-surface-variant shadow-sm border border-outline-variant/30">
                    Belum ada jadwal les
                </div>
                @endforelse
                
                @if(count($jadwalTerdekat) > 0)
                <a href="{{ route('siswa.jadwal.index') }}" class="block w-full py-4 rounded-2xl bg-surface-container-high text-on-surface-variant text-center font-bold text-sm hover:bg-primary-fixed-dim transition-colors mt-2">
                    Lihat Kalender Lengkap
                </a>
                @endif
            </div>
        </section>
    </div>


</div>
@endsection
