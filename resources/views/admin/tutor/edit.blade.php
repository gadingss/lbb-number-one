@extends('layouts.app')

@section('title', 'Edit Tutor')

@section('content')
{{-- Welcome & Title Section --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h3 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Edit Data Tutor</h3>
        <p class="text-on-surface-variant mt-1">Perbarui informasi profil dan akun login pengajar.</p>
    </div>
    <a href="{{ route('admin.tutor.index') }}"
       class="flex items-center gap-2 text-on-surface-variant font-bold hover:text-primary transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
        Kembali ke Daftar Tutor
    </a>
</div>

{{-- Error Messages --}}
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

{{-- Tutor Profile Summary Card --}}
<div class="bg-surface-container-lowest rounded-[2rem] p-8 mb-8 flex items-center gap-6 relative overflow-hidden group">
    <div class="absolute top-0 right-0 w-48 h-48 bg-primary/5 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500"></div>
    <div class="relative z-10 w-20 h-20 rounded-[1.5rem] bg-secondary-container flex items-center justify-center text-on-secondary-container font-black text-3xl ring-4 ring-surface-container-low shadow-xl">
        {{ substr($tutor->user->name ?? 'T', 0, 1) }}
    </div>
    <div class="relative z-10 flex-1">
        <h4 class="text-xl font-headline font-bold text-on-surface">{{ $tutor->user->name ?? '-' }}</h4>
        <p class="text-on-surface-variant font-medium">{{ $tutor->mataPelajaran->nama_mapel ?? '-' }} • {{ $tutor->pendidikan_terakhir ?? '-' }}</p>
        <p class="text-xs text-outline mt-1">{{ $tutor->user->email ?? '-' }}</p>
    </div>
    <div class="relative z-10 hidden md:flex items-center gap-3">
        <div class="bg-surface-container-low px-4 py-2 rounded-xl text-center">
            <span class="block text-xs text-outline font-bold uppercase">No HP</span>
            <span class="text-sm font-bold text-on-surface">{{ $tutor->no_hp ?? '-' }}</span>
        </div>
    </div>
</div>

{{-- Form Card --}}
<div class="bg-surface-container-lowest rounded-[2rem] overflow-hidden">
    <div class="p-8 bg-white/40 backdrop-blur-sm border-b border-surface-container-high">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">edit_note</span>
            </div>
            <div>
                <h4 class="text-xl font-headline font-bold">Formulir Edit Tutor</h4>
                <p class="text-xs text-on-surface-variant">Perbarui data akun & profil pengajar</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.tutor.update', $tutor->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')

        {{-- Section: Informasi Akun --}}
        <div class="mb-10">
            <h5 class="text-sm font-bold text-primary uppercase tracking-widest mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">account_circle</span>
                Informasi Akun Login
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $tutor->user->name) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Masukkan nama lengkap pengajar" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email Utama (Untuk Login)</label>
                    <input type="email" name="email" value="{{ old('email', $tutor->user->email) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="contoh@email.com" required>
                </div>

                {{-- Password --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Password Baru</label>
                    <input type="password" name="password"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Kosongkan jika tidak ingin mengubah sandi login" minlength="8">
                    <p class="mt-2 text-xs text-outline flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">info</span>
                        Biarkan kosong jika tidak ingin mengubah password
                    </p>
                </div>
            </div>
        </div>

        {{-- Section: Informasi Kontak --}}
        <div class="mb-10">
            <h5 class="text-sm font-bold text-primary uppercase tracking-widest mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">contact_phone</span>
                Informasi Kontak
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- No HP --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $tutor->no_hp) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="08xxxxxxxxxx" required>
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Alamat</label>
                    <textarea name="alamat" rows="3"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all resize-none"
                        placeholder="Alamat lengkap pengajar" required>{{ old('alamat', $tutor->alamat) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section: Profil Profesional --}}
        <div class="mb-10">
            <h5 class="text-sm font-bold text-primary uppercase tracking-widest mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">school</span>
                Profil Profesional
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Mata Pelajaran --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Mata Pelajaran Utama</label>
                    <select name="mata_pelajaran_id"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all" required>
                        <option value="">Pilih Mata Pelajaran...</option>
                        @foreach($mataPelajarans as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $tutor->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pendidikan Terakhir --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $tutor->pendidikan_terakhir) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Contoh: S1 Pendidikan Matematika" required>
                </div>
                
                {{-- Kuota Siswa --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Maksimal Kuota Siswa</label>
                    <input type="number" name="kuota_siswa" value="{{ old('kuota_siswa', $tutor->kuota_siswa ?? 5) }}" min="1"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Contoh: 5" required>
                    <p class="text-xs text-on-surface-variant mt-1">Batas maksimum siswa aktif yang dapat ditangani oleh tutor ini secara bersamaan.</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-4 pt-6 border-t border-surface-container-high">
            <button type="submit"
                class="flex items-center gap-2 bg-gradient-to-br from-primary to-primary-container text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 hover:scale-[1.02] active:scale-95">
                <span class="material-symbols-outlined">save</span>
                Perbarui Data Tutor
            </button>

            <a href="{{ route('admin.tutor.index') }}"
               class="flex items-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-xl font-bold hover:bg-surface-variant transition-all">
                <span class="material-symbols-outlined">close</span>
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Bottom spacer --}}
<div class="h-10"></div>
@endsection
