@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h3 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Edit Mata Pelajaran</h3>
        <p class="text-on-surface-variant mt-1">Perbarui detail mata pelajaran.</p>
    </div>
    <a href="{{ route('admin.mata-pelajaran.index') }}"
       class="flex items-center gap-2 text-on-surface-variant font-bold hover:text-primary transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
        Kembali
    </a>
</div>

@if ($errors->any())
    <div class="bg-error-container/30 border border-error/20 text-on-error-container p-6 mb-8 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-error/10 text-error flex-shrink-0 flex items-center justify-center">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
        </div>
        <div>
            <p class="font-bold text-sm mb-2">Terdapat kesalahan pada data yang dimasukkan:</p>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="bg-surface-container-lowest rounded-[2rem] overflow-hidden max-w-3xl">
    <div class="p-8 bg-white/40 backdrop-blur-sm border-b border-surface-container-high">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">edit_note</span>
            </div>
            <div>
                <h4 class="text-xl font-headline font-bold">Formulir Edit</h4>
                <p class="text-xs text-on-surface-variant">Ubah informasi kurikulum</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.mata-pelajaran.update', $mata_pelajaran->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div>
                <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nama Mata Pelajaran</label>
                <input type="text" name="nama_mapel" value="{{ old('nama_mapel', $mata_pelajaran->nama_mapel) }}"
                    class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                    required>
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all resize-none">{{ old('deskripsi', $mata_pelajaran->deskripsi) }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-surface-container-high">
            <button type="submit"
                class="flex items-center gap-2 bg-gradient-to-br from-primary to-primary-container text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 hover:scale-[1.02] active:scale-95">
                <span class="material-symbols-outlined">save</span>
                Perbarui Data
            </button>
            <a href="{{ route('admin.mata-pelajaran.index') }}"
               class="flex items-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-xl font-bold hover:bg-surface-variant transition-all">
                <span class="material-symbols-outlined">close</span>
                Batal
            </a>
        </div>
    </form>
</div>
@endsection