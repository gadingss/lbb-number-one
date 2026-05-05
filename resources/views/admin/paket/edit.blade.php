@extends('layouts.app')

@section('title', 'Edit Paket Les')

@section('content')
<!-- Page Header -->
<div class="mb-10">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.paket.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
        </a>
        <p class="text-blue-700 font-semibold tracking-widest text-[10px] uppercase">Manajemen Paket</p>
    </div>
    <h2 class="text-4xl font-headline font-extrabold text-slate-800 tracking-tight">Edit Paket Les</h2>
</div>

<!-- Main Form -->
<div class="grid grid-cols-12 gap-8">
    <section class="col-span-12 xl:col-span-8 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
        <h3 class="font-headline text-xl font-bold text-slate-800 mb-8 flex items-center">
            <span class="material-symbols-outlined mr-3 text-blue-600" style="font-variation-settings: 'FILL' 1;">edit_document</span>
            Informasi Paket
        </h3>

        @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 mb-8 rounded-xl border border-red-100 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Paket</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">auto_stories</span>
                    <input type="text" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jumlah Pertemuan (Sesi)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">schedule</span>
                        <input type="number" name="jumlah_pertemuan" value="{{ old('jumlah_pertemuan', $paket->jumlah_pertemuan) }}" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Harga (Rp)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">payments</span>
                        <input type="number" name="harga" value="{{ old('harga', $paket->harga) }}" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700" required>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Deskripsi Tambahan</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-4 text-slate-400">description</span>
                    <textarea name="deskripsi" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700 resize-none" rows="4">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="pt-6 flex gap-3 justify-end border-t border-slate-100">
                <a href="{{ route('admin.paket.index') }}" class="px-6 py-2.5 rounded-xl font-headline font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="bg-gradient-to-br from-blue-600 to-blue-800 text-white px-8 py-2.5 rounded-xl font-headline font-bold text-sm shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>

    <!-- Sidebar Guidelines -->
    <section class="col-span-12 xl:col-span-4 space-y-6">
        <div class="bg-blue-50/50 border border-blue-100 rounded-3xl p-8">
            <h4 class="font-headline font-bold text-blue-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">info</span>
                Panduan Pengeditan
            </h4>
            <p class="text-sm text-blue-800/80 leading-relaxed mb-4">
                Pastikan nama paket dan harga diisi dengan benar. Perubahan ini akan segera terlihat pada halaman siswa dan pengajar.
            </p>
            <ul class="text-sm text-blue-800/80 space-y-2">
                <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> <b>Harga:</b> Ditulis angka murni (tanpa titik).</li>
                <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> <b>Sesi:</b> Hitungan total pertemuan les.</li>
            </ul>
        </div>
    </section>
</div>
@endsection
