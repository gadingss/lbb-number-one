@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
<!-- Page Header -->
<div class="flex justify-between items-end mb-10">
    <div>
        <h2 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Kelola Pembayaran</h2>
        <p class="text-on-surface-variant mt-2">Manajemen arus kas dan status transaksi siswa secara real-time.</p>
    </div>
    <a href="{{ route('admin.pembayaran.create') }}" class="bg-gradient-to-br from-primary to-primary-container text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] transition-transform hover:scale-[1.02] active:scale-[0.98]">
        <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
        Tambah Pembayaran Baru
    </a>
</div>

@if(session('success'))
    <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-bold">Success!</span> {{ session('success') }}
    </div>
@endif

<!-- Metrics Row (Bento Style) -->
<div class="grid grid-cols-12 gap-6 mb-10">
    <div class="col-span-12 lg:col-span-5 bg-surface-container-lowest p-8 rounded-2xl shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] border border-outline-variant/10">
        <p class="text-label text-slate-500 font-semibold tracking-wider uppercase text-xs mb-4">Total Pendapatan Bulan Ini</p>
        <div class="flex items-end gap-4">
            <h3 class="text-4xl lg:text-5xl font-display font-black text-primary">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <div class="col-span-12 lg:col-span-3 bg-surface-container-low p-8 rounded-2xl border border-outline-variant/10">
        <p class="text-label text-slate-500 font-semibold tracking-wider uppercase text-xs mb-4">Menunggu Konfirmasi</p>
        <div class="flex items-center gap-4">
            <span class="text-4xl font-display font-extrabold text-tertiary">{{ $menungguKonfirmasi }}</span>
            <div class="h-12 w-12 rounded-full bg-tertiary-fixed flex items-center justify-center">
                <span class="material-symbols-outlined text-tertiary" data-icon="pending_actions">pending_actions</span>
            </div>
        </div>
    </div>
    
    <div class="col-span-12 lg:col-span-4 bg-surface-container-lowest p-8 rounded-2xl shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] border border-outline-variant/10">
        <p class="text-label text-slate-500 font-semibold tracking-wider uppercase text-xs mb-4">Metode Terpopuler</p>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <h4 class="text-xl font-bold">{{ ucfirst($metodeTerpopuler) }}</h4>
                <p class="text-xs text-on-surface-variant">Metode yang paling sering digunakan</p>
            </div>
            <div class="h-14 w-14 rounded-2xl bg-secondary-container flex items-center justify-center">
                <span class="material-symbols-outlined text-on-secondary-container text-2xl" data-icon="account_balance">account_balance</span>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search Bar -->
<form method="GET" action="{{ route('admin.pembayaran.index') }}" class="bg-surface-container-low p-6 rounded-2xl mb-8 flex flex-wrap items-end gap-4">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Cari Nama Siswa</label>
        <div class="bg-white px-4 py-2.5 rounded-xl flex items-center border border-outline-variant/20 focus-within:ring-2 focus-within:ring-primary/20">
            <span class="material-symbols-outlined text-slate-300 mr-2" data-icon="person_search">person_search</span>
            <input name="search" value="{{ request('search') }}" class="bg-transparent border-none p-0 focus:ring-0 text-sm w-full outline-none" placeholder="Masukkan nama..." type="text"/>
        </div>
    </div>
    
    <div class="w-48">
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Status</label>
        <select name="status" class="w-full bg-white px-4 py-2.5 rounded-xl border border-outline-variant/20 text-sm focus:ring-2 focus:ring-primary/20 outline-none">
            <option value="">Semua Status</option>
            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
        </select>
    </div>
    
    <div class="w-80">
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 ml-1">Rentang Tanggal</label>
        <div class="flex items-center gap-2">
            <input name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="bg-white px-3 py-2.5 rounded-xl border border-outline-variant/20 text-xs w-full focus:ring-2 focus:ring-primary/20 outline-none" type="date"/>
            <span class="text-slate-400">—</span>
            <input name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="bg-white px-3 py-2.5 rounded-xl border border-outline-variant/20 text-xs w-full focus:ring-2 focus:ring-primary/20 outline-none" type="date"/>
        </div>
    </div>
    
    <div>
        <button type="submit" class="bg-on-surface text-white px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
            Filter
        </button>
    </div>
</form>

<!-- Transaction Table Container -->
<div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] border border-outline-variant/10">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-surface-container-high">
                <tr>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">No</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">Siswa</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">Paket Belajar</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">Jumlah</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">Metode</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">Tanggal</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em]">Status</th>
                    <th class="py-5 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.05em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pembayarans as $index => $pembayaran)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="py-6 px-6 text-sm text-slate-400">{{ $pembayarans->firstItem() + $index }}</td>
                        <td class="py-6 px-6">
                            <div class="flex items-center gap-3">
                                @php
                                    $initials = collect(explode(' ', $pembayaran->siswa->user->name ?? 'User'))->map(function($word) { return strtoupper(substr($word, 0, 1)); })->take(2)->join('');
                                    $colors = ['bg-blue-100 text-blue-600', 'bg-purple-100 text-purple-600', 'bg-orange-100 text-orange-600', 'bg-green-100 text-green-600', 'bg-pink-100 text-pink-600'];
                                    $colorClass = $colors[$index % count($colors)];
                                @endphp
                                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs {{ $colorClass }}">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $pembayaran->siswa->user->name }}</p>
                                    <p class="text-xs text-slate-400">INV-{{ str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <span class="text-sm font-medium text-on-surface-variant">{{ $pembayaran->paket->nama_paket ?? '-' }}</span>
                        </td>
                        <td class="py-6 px-6">
                            <span class="text-sm font-bold text-on-surface">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-lg" data-icon="account_balance">account_balance</span>
                                <span class="text-xs text-on-surface-variant capitalize">{{ $pembayaran->metode_pembayaran }}</span>
                            </div>
                        </td>
                        <td class="py-6 px-6 text-sm text-on-surface-variant">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</td>
                        <td class="py-6 px-6">
                            @if($pembayaran->status == 'lunas')
                                <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-black uppercase tracking-wider rounded-full">Lunas</span>
                            @elseif($pembayaran->status == 'pending')
                                <span class="px-3 py-1 bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-black uppercase tracking-wider rounded-full">Menunggu</span>
                            @else
                                <span class="px-3 py-1 bg-error-container text-on-error-container text-[10px] font-black uppercase tracking-wider rounded-full">Gagal</span>
                            @endif
                        </td>
                        <td class="py-6 px-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.pembayaran.edit', $pembayaran->id) }}" class="p-2 bg-white text-primary rounded-lg shadow-sm border border-outline-variant/10 hover:bg-primary hover:text-white transition-all" title="Edit">
                                    <span class="material-symbols-outlined text-sm" data-icon="edit">edit</span>
                                </a>
                                <form action="{{ route('admin.pembayaran.destroy', $pembayaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-white text-error rounded-lg shadow-sm border border-outline-variant/10 hover:bg-error hover:text-white transition-all" title="Hapus">
                                        <span class="material-symbols-outlined text-sm" data-icon="delete">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-500">
                            <span class="material-symbols-outlined text-4xl mb-2" data-icon="receipt_long">receipt_long</span>
                            <p class="font-medium">Belum ada transaksi ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 bg-white border-t border-slate-50">
        {{ $pembayarans->links('pagination::tailwind') }}
    </div>
</div>

<!-- Asymmetric Support Section -->
<div class="mt-12 flex flex-col md:flex-row gap-6">
    <div class="flex-1 bg-white p-8 rounded-3xl shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] border border-outline-variant/5">
        <div class="flex items-start gap-6">
            <div class="h-16 w-16 rounded-2xl bg-blue-50 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl filled-icon" data-icon="analytics">analytics</span>
            </div>
            <div>
                <h5 class="text-xl font-bold mb-2">Laporan Rekapitulasi</h5>
                <p class="text-on-surface-variant text-sm mb-6 max-w-md">Masuk ke halaman laporan untuk melihat data secara menyeluruh dan mengunduh format cetak jika diperlukan.</p>
                <div class="flex gap-3">
                    <a href="{{ route('admin.pembayaran.laporan') }}" class="px-5 py-2.5 bg-surface-container-high text-primary rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-blue-100 transition-colors">
                        <span class="material-symbols-outlined text-sm" data-icon="table_view">table_view</span>
                        Lihat Laporan Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="w-full md:w-80 bg-blue-900 text-white p-8 rounded-3xl shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] flex flex-col justify-between">
        <div>
            <span class="inline-block px-3 py-1 bg-blue-800 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">Tips Admin</span>
            <h5 class="text-lg font-bold leading-tight mb-2">Manajemen Efektif</h5>
            <p class="text-blue-200 text-xs leading-relaxed">Gunakan filter status "Pending" untuk melihat pembayaran yang memerlukan verifikasi segera guna menjaga kelancaran akses siswa.</p>
        </div>
        <div class="mt-6 flex items-center text-xs font-bold text-blue-100 group cursor-pointer">
            Selalu cek mutasi bank harian
        </div>
    </div>
</div>
@endsection
