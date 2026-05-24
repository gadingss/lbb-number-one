@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-end mb-10">
    <div>
        <h2 class="text-4xl font-extrabold tracking-tight text-on-background mb-2">Mata Pelajaran</h2>
        <p class="text-slate-500 font-medium max-w-md">Kelola daftar mata pelajaran utama yang diajarkan di institusi Anda.</p>
    </div>
    <a href="{{ route('admin.mata-pelajaran.create') }}" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-br from-primary to-primary-container text-white rounded-xl font-bold shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
        <span class="material-symbols-outlined">add_circle</span>
        Tambah Mapel
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-semibold text-sm">{{ session('success') }}</span>
</div>
@endif

<!-- Data Table -->
<div class="bg-surface-container-low rounded-3xl overflow-hidden shadow-sm">
    <div class="p-8 pb-4 flex justify-between items-center">
        <h4 class="text-lg font-bold text-on-background">Daftar Mata Pelajaran</h4>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-high/50">
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest w-16">No</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Mata Pelajaran</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Deskripsi</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse ($mataPelajarans as $mapel)
                <tr class="group hover:bg-surface-container-high/30 transition-colors border-b border-outline-variant/10 last:border-0">
                    <td class="px-8 py-5 text-sm font-bold text-slate-400">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-bold">
                                {{ substr($mapel->nama_mapel, 0, 1) }}
                            </div>
                            <p class="text-sm font-bold text-on-background">{{ $mapel->nama_mapel }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-sm text-slate-500 line-clamp-2" title="{{ $mapel->deskripsi }}">{{ $mapel->deskripsi ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.mata-pelajaran.edit', $mapel->id) }}" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors inline-block" title="Edit">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </a>
                            <form action="{{ route('admin.mata-pelajaran.destroy', $mapel->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mapel ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 px-6 text-center text-slate-500 text-sm">
                        <div class="flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-5xl text-slate-300">menu_book</span>
                            <p class="font-semibold">Belum ada data mata pelajaran.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection