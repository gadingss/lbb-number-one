@extends('layouts.siswa')

@section('title', 'Pilih Paket Belajar')

@section('content')
<!-- Header Section -->
<section class="max-w-6xl mx-auto mb-12">
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="max-w-2xl">
            <h2 class="font-headline text-2xl sm:text-4xl font-extrabold tracking-tight text-on-surface mb-3">Pilih Paket Belajar</h2>
            <p class="text-on-surface-variant text-lg leading-relaxed">Temukan kurikulum yang dirancang khusus untuk mengakselerasi potensi akademik Anda.</p>
        </div>
        
        <!-- Status Banner -->
        @if($paketAktif)
        <div class="bg-primary-fixed/30 border-l-4 border-primary px-6 py-4 rounded-xl flex items-center gap-4 backdrop-blur-sm">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>
            <div>
                <p class="text-xs font-bold text-primary uppercase tracking-wider">Status Sekarang</p>
                <p class="text-on-surface font-semibold">Anda memiliki paket aktif: <span class="text-primary">{{ $paketAktif->paket->nama_paket }}</span></p>
            </div>
        </div>
        @else
        <div class="bg-surface-container-highest border-l-4 border-outline-variant px-6 py-4 rounded-xl flex items-center gap-4 backdrop-blur-sm">
            <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined">info</span>
            </div>
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status Sekarang</p>
                <p class="text-on-surface font-semibold">Anda belum memiliki paket aktif</p>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Package Catalog - Bento/Grid Layout -->
<section class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-8">
    @forelse($pakets as $paket)
        @if(isset($popularPaketId) && $paket->id == $popularPaketId)
            <!-- Card 2: Featured Style (Paling Populer) -->
            <div class="group relative bg-surface-container-lowest rounded-2xl p-8 flex flex-col h-full border-2 border-primary active-glow transition-all duration-300 sm:scale-105 z-10 overflow-hidden">
                <!-- Badge -->
                <div class="absolute top-0 right-0 bg-primary text-white px-6 py-2 rounded-bl-2xl text-xs font-black uppercase tracking-widest shadow-lg">
                    Paling Populer
                </div>
                
                <div class="mb-8">
                    <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center text-white mb-6 group-hover:rotate-3 transition-transform shadow-xl shadow-primary/20">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                    </div>
                    <h3 class="font-headline text-2xl font-bold text-on-surface mb-1">{{ $paket->nama_paket }}</h3>
                    <p class="text-primary font-bold">{{ $paket->deskripsi ?? $paket->jumlah_pertemuan . ' sesi per bulan' }}</p>
                </div>
                
                <div class="space-y-4 mb-10 flex-1">
                    <div class="flex justify-between items-center py-3 border-b border-primary/10">
                        <span class="text-on-surface-variant text-sm">Mata Pelajaran:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->mataPelajaran->nama_mapel ?? 'Umum' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-primary/10">
                        <span class="text-on-surface-variant text-sm">Jumlah Pertemuan:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->jumlah_pertemuan }}x</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-primary/10">
                        <span class="text-on-surface-variant text-sm">Durasi Sesi:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->durasi_pertemuan }} Menit</span>
                    </div>
                    

                </div>
                
                <div class="mt-auto">
                    <p class="text-4xl font-extrabold text-primary mb-6">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                    @if(in_array($paket->id, $activePaketIds))
                        <button disabled class="block text-center w-full py-4 bg-surface-container-high text-on-surface-variant rounded-xl font-bold opacity-70 cursor-not-allowed">
                            Masih Aktif
                        </button>
                    @else
                        <a href="{{ route('siswa.paket.pilih-jadwal', $paket->id) }}" class="block text-center w-full py-4 bg-gradient-to-br from-primary to-primary-container text-white rounded-xl font-bold shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                            Pilih Paket
                        </a>
                    @endif
                </div>
            </div>

        @elseif($loop->iteration % 2 == 0)
            <!-- Card 3: Premium Style -->
            <div class="group relative bg-surface-container-lowest rounded-2xl p-8 flex flex-col h-full border border-outline-variant/10 hover:border-primary/20 transition-all duration-300">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-surface-container-low rounded-2xl flex items-center justify-center text-tertiary mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">workspace_premium</span>
                    </div>
                    <h3 class="font-headline text-2xl font-bold text-on-surface mb-1">{{ $paket->nama_paket }}</h3>
                    <p class="text-on-surface-variant font-medium">{{ $paket->deskripsi ?? $paket->jumlah_pertemuan . ' sesi per bulan' }}</p>
                </div>
                
                <div class="space-y-4 mb-10 flex-1">
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                        <span class="text-on-surface-variant text-sm">Mata Pelajaran:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->mataPelajaran->nama_mapel ?? 'Semua Mapel UN' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                        <span class="text-on-surface-variant text-sm">Jumlah Pertemuan:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->jumlah_pertemuan }}x</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                        <span class="text-on-surface-variant text-sm">Durasi Sesi:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->durasi_pertemuan }} Menit</span>
                    </div>
                </div>
                
                <div class="mt-auto">
                    <p class="text-3xl font-extrabold text-primary mb-6">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                    @if(in_array($paket->id, $activePaketIds))
                        <button disabled class="block text-center w-full py-4 bg-surface-container-high text-on-surface-variant rounded-xl font-bold opacity-70 cursor-not-allowed">
                            Masih Aktif
                        </button>
                    @else
                        <a href="{{ route('siswa.paket.pilih-jadwal', $paket->id) }}" class="block text-center w-full py-4 bg-surface-container-high text-primary hover:bg-primary hover:text-white rounded-xl font-bold transition-all duration-300">
                            Pilih Paket
                        </a>
                    @endif
                </div>
            </div>
            
        @else
            <!-- Card 1: Standard Style -->
            <div class="group relative bg-surface-container-lowest rounded-2xl p-8 flex flex-col h-full border border-outline-variant/10 hover:border-primary/20 transition-all duration-300">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-surface-container-low rounded-2xl flex items-center justify-center text-primary-container mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">menu_book</span>
                    </div>
                    <h3 class="font-headline text-2xl font-bold text-on-surface mb-1">{{ $paket->nama_paket }}</h3>
                    <p class="text-on-surface-variant font-medium">{{ $paket->deskripsi ?? $paket->jumlah_pertemuan . ' sesi per bulan' }}</p>
                </div>
                
                <div class="space-y-4 mb-10 flex-1">
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                        <span class="text-on-surface-variant text-sm">Mata Pelajaran:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->mataPelajaran->nama_mapel ?? 'Umum' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                        <span class="text-on-surface-variant text-sm">Jumlah Pertemuan:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->jumlah_pertemuan }}x</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                        <span class="text-on-surface-variant text-sm">Durasi Sesi:</span>
                        <span class="text-on-surface font-bold text-sm">{{ $paket->durasi_pertemuan }} Menit</span>
                    </div>
                </div>
                
                <div class="mt-auto">
                    <p class="text-3xl font-extrabold text-primary mb-6">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                    @if(in_array($paket->id, $activePaketIds))
                        <button disabled class="block text-center w-full py-4 bg-surface-container-high text-on-surface-variant rounded-xl font-bold opacity-70 cursor-not-allowed">
                            Masih Aktif
                        </button>
                    @else
                        <a href="{{ route('siswa.paket.pilih-jadwal', $paket->id) }}" class="block text-center w-full py-4 bg-surface-container-high text-primary hover:bg-primary hover:text-white rounded-xl font-bold transition-all duration-300">
                            Pilih Paket
                        </a>
                    @endif
                </div>
            </div>
            
        @endif
        
    @empty
        <div class="col-span-full text-center py-12 bg-surface-container-lowest rounded-2xl border border-outline-variant/20">
            <span class="material-symbols-outlined text-6xl text-outline-variant/50 mb-4 block">inventory_2</span>
            <p class="text-on-surface-variant font-medium text-lg">Belum ada paket yang tersedia saat ini.</p>
        </div>
    @endforelse
</section>

<!-- Footer Section -->
<footer class="max-w-6xl mx-auto mt-20 pt-8 border-t border-outline-variant/10 flex flex-col md:flex-row justify-between items-center gap-6">
    <div class="text-on-surface-variant text-sm">
        &copy; {{ date('Y') }} LBB Number One. Part of The Academic Atelier.
    </div>
    <div class="flex gap-8">
        <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#">Syarat &amp; Ketentuan</a>
        <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#">Pusat Bantuan</a>
        <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#">Kontak Support</a>
    </div>
</footer>
@endsection
