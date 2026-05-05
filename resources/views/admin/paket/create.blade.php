@extends('layouts.app')

@section('title', 'Tambah Paket Les')

@section('content')
<!-- Page Header -->
<div class="mb-10">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.paket.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
        </a>
        <p class="text-blue-700 font-semibold tracking-widest text-[10px] uppercase">Manajemen Paket</p>
    </div>
    <h2 class="text-4xl font-headline font-extrabold text-slate-800 tracking-tight">Tambah Paket Baru</h2>
</div>

<!-- Main Form -->
<div class="grid grid-cols-12 gap-8">
    <section class="col-span-12 xl:col-span-8 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
        <h3 class="font-headline text-xl font-bold text-slate-800 mb-8 flex items-center">
            <span class="material-symbols-outlined mr-3 text-blue-600" style="font-variation-settings: 'FILL' 1;">add_box</span>
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

        <form action="{{ route('admin.paket.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Paket</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">auto_stories</span>
                    <input type="text" name="nama_paket" value="{{ old('nama_paket') }}" placeholder="Contoh: Paket SD Reguler" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jumlah Pertemuan (Sesi)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">schedule</span>
                        <input type="number" name="jumlah_pertemuan" value="{{ old('jumlah_pertemuan') }}" placeholder="Contoh: 8" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Harga (Rp)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">payments</span>
                        <input type="number" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 350000" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700" required>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Deskripsi Tambahan</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-4 text-slate-400">description</span>
                    <textarea name="deskripsi" class="w-full bg-slate-50 border-none rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700 resize-none" rows="4" placeholder="Keterangan singkat tentang paket ini...">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <div class="pt-6 flex gap-3 justify-end border-t border-slate-100">
                <a href="{{ route('admin.paket.index') }}" class="px-6 py-2.5 rounded-xl font-headline font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="bg-gradient-to-br from-emerald-500 to-emerald-700 text-white px-8 py-2.5 rounded-xl font-headline font-bold text-sm shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all">
                    Simpan Paket Baru
                </button>
            </div>
        </form>
    </section>

    <!-- Sidebar Guidelines -->
    <section class="col-span-12 xl:col-span-4 space-y-6">
        <div class="bg-emerald-50/50 border border-emerald-100 rounded-3xl p-8">
            <h4 class="font-headline font-bold text-emerald-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">lightbulb</span>
                Tips Pembuatan Paket
            </h4>
            <p class="text-sm text-emerald-800/80 leading-relaxed mb-4">
                Paket les yang menarik akan lebih diminati. Berikan deskripsi yang jelas dan harga yang bersaing.
            </p>
            <ul class="text-sm text-emerald-800/80 space-y-2">
                <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Tuliskan harga tanpa tanda titik/koma.</li>
                <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Nama paket harus singkat & mudah diingat.</li>
            </ul>
        </div>
    </section>
</div>
@endsection
