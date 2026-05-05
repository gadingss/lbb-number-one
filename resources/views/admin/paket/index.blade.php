@extends('layouts.app')

@section('title', 'Manajemen Paket Les')

@section('content')
<!-- Page Header -->
<section class="mb-10 flex justify-between items-end">
    <div>
        <p class="text-blue-700 font-semibold tracking-widest text-[10px] uppercase mb-1">Les Bimbel Private</p>
        <h2 class="text-4xl font-headline font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">Manajemen Paket Les</h2>
    </div>
    <a href="{{ route('admin.paket.create') }}" class="bg-gradient-to-br from-blue-600 to-blue-800 text-white px-6 py-3 rounded-xl font-headline font-bold text-sm flex items-center gap-2 shadow-lg shadow-blue-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">add</span>
        Tambah Paket Baru
    </a>
</section>

@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3 mb-8">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        {{ session('success') }}
    </div>
@endif

<!-- Bento Grid Summary -->
<section class="grid grid-cols-12 gap-6 mb-12">
    <!-- Main Stat Card -->
    <div class="col-span-12 lg:col-span-5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-8 rounded-3xl relative overflow-hidden flex flex-col justify-between shadow-sm">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/5 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Metrik Sistem</span>
            <h3 class="text-slate-500 font-medium text-sm mt-4">Total Paket Aktif</h3>
            <p class="text-6xl font-headline font-extrabold text-blue-700 mt-2">{{ $totalPaket }}</p>
        </div>
        <div class="mt-8 flex items-center gap-2 text-xs font-semibold text-emerald-600 bg-emerald-50 w-fit px-3 py-1 rounded-full">
            <span class="material-symbols-outlined text-sm">inventory_2</span>
            <span>Paket Tersedia</span>
        </div>
    </div>

    <!-- Asymmetric Grid Column -->
    <div class="col-span-12 lg:col-span-7 grid grid-cols-2 gap-6">
        <div class="bg-slate-50 dark:bg-slate-800/50 p-8 rounded-3xl flex flex-col justify-between hover:bg-white dark:hover:bg-slate-800 transition-colors duration-300 border border-slate-100 dark:border-slate-700/50 shadow-sm">
            <div>
                <span class="material-symbols-outlined text-amber-500 text-3xl" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                <h3 class="text-slate-500 font-medium text-sm mt-4">Paket Paling Populer</h3>
                <p class="text-xl lg:text-2xl font-headline font-bold text-slate-800 dark:text-slate-100 mt-2 truncate">{{ $topPaket ? $topPaket->nama_paket : '-' }}</p>
            </div>
            <p class="text-xs text-slate-400 mt-4 italic">{{ $topPaket ? $topPaket->pembayarans_count . ' pendaftar' : 'Belum ada data' }} transaksional</p>
        </div>
        <div class="bg-slate-50 dark:bg-slate-800/50 p-8 rounded-3xl flex flex-col justify-between hover:bg-white dark:hover:bg-slate-800 transition-colors duration-300 border border-slate-100 dark:border-slate-700/50 shadow-sm">
            <div>
                <span class="material-symbols-outlined text-blue-600 text-3xl" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                <h3 class="text-slate-500 font-medium text-sm mt-4">Pendapatan Rata-rata</h3>
                <p class="text-2xl font-headline font-bold text-slate-800 dark:text-slate-100 mt-2 truncate">Rp {{ number_format($avgPrice / 1000, 0, ',', '.') }}k <span class="text-sm font-normal text-slate-400">/paket</span></p>
            </div>
            <div class="mt-4 h-1 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 w-3/4"></div>
            </div>
        </div>
    </div>
</section>

<!-- Main Table Section -->
<section class="bg-slate-50 dark:bg-slate-800/50 p-1 rounded-[1.5rem] overflow-hidden shadow-sm border border-slate-100 dark:border-slate-700/50">
    <div class="bg-white dark:bg-slate-900 rounded-[1.25rem] overflow-hidden">
        <div class="px-8 py-6 flex justify-between items-center bg-white dark:bg-slate-900">
            <h3 class="font-headline font-extrabold text-lg tracking-tight text-slate-800 dark:text-slate-100">Daftar Paket Les</h3>
            <div class="flex gap-2">
                <button class="text-slate-500 text-xs font-bold border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">filter_list</span>
                    Filter
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">No</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Nama Paket & Deskripsi</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Harga</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Jumlah Pertemuan</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    @forelse($pakets as $paket)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                            <td class="px-8 py-6 text-sm font-medium text-slate-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex flex-shrink-0 items-center justify-center text-blue-600">
                                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                                    </div>
                                    <div>
                                        <p class="font-headline font-bold text-slate-800 dark:text-slate-100">{{ $paket->nama_paket }}</p>
                                        <p class="text-[10px] text-slate-500 font-medium mt-0.5 truncate max-w-[200px]">{{ $paket->deskripsi ?? 'Reguler Series' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-6">
                                <p class="font-headline font-bold text-slate-800 dark:text-slate-100 text-sm">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-4 py-6">
                                <div class="flex items-center gap-2 text-slate-500">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    <span class="text-sm font-medium">{{ $paket->jumlah_pertemuan }} Sesi</span>
                                </div>
                            </td>
                            <td class="px-4 py-6">
                                <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-[10px] font-bold px-3 py-1.5 rounded-lg border border-blue-100 dark:border-blue-800 whitespace-nowrap">Aktif Berjalan</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.paket.edit', $paket->id) }}" title="Edit" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-slate-700 text-slate-400 hover:text-blue-600 transition-colors border border-transparent hover:border-slate-200 dark:hover:border-slate-600 shadow-sm">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-slate-700 text-slate-400 hover:text-red-500 transition-colors border border-transparent hover:border-slate-200 dark:hover:border-slate-600 shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus paket {{ $paket->nama_paket }}? Data yang terkait mungkin akan terpengaruh.')">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined text-5xl mb-4 opacity-50">inventory_2</span>
                                    <p class="font-headline font-bold text-lg text-slate-600">Belum ada paket les</p>
                                    <p class="text-sm mt-1 mb-4">Tambahkan paket les baru untuk mulai menawarkan bimbingan.</p>
                                    <a href="{{ route('admin.paket.create') }}" class="text-blue-600 font-bold text-sm bg-blue-50 px-4 py-2 rounded-xl border border-blue-100">Buat Paket Pertama</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Container -->
        @if($pakets->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
            {{ $pakets->links() }}
        </div>
        @else
        <div class="px-8 py-4 bg-slate-50/50 dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-500 font-medium">
            <span>Menampilkan {{ $pakets->count() }} data paket</span>
        </div>
        @endif
    </div>
</section>
@endsection