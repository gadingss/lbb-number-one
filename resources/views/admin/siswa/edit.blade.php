@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
{{-- Welcome & Title Section --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h3 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Edit Data Siswa</h3>
        <p class="text-on-surface-variant mt-1">Perbarui informasi profil dan akun login siswa.</p>
    </div>
    <a href="{{ route('admin.siswa.index') }}"
       class="flex items-center gap-2 text-on-surface-variant font-bold hover:text-primary transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
        Kembali ke Direktori
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

{{-- Student Profile Summary Card --}}
<div class="bg-surface-container-lowest rounded-[2rem] p-8 mb-8 flex items-center gap-6 relative overflow-hidden group">
    <div class="absolute top-0 right-0 w-48 h-48 bg-primary/5 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500"></div>
    <div class="relative z-10 w-20 h-20 rounded-[1.5rem] bg-secondary-container flex items-center justify-center text-on-secondary-container font-black text-3xl ring-4 ring-surface-container-low shadow-xl">
        {{ substr($siswa->user->name ?? 'S', 0, 1) }}
    </div>
    <div class="relative z-10">
        <h4 class="text-xl font-headline font-bold text-on-surface">{{ $siswa->user->name ?? '-' }}</h4>
        <p class="text-on-surface-variant font-medium">{{ $siswa->kelas ?? '-' }} • {{ $siswa->sekolah ?? '-' }}</p>
        <p class="text-xs text-outline mt-1">{{ $siswa->user->email ?? '-' }}</p>
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
                <h4 class="text-xl font-headline font-bold">Formulir Edit</h4>
                <p class="text-xs text-on-surface-variant">Perbarui data akun & profil siswa</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="p-8">
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
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nama Lengkap Siswa</label>
                    <input type="text" name="name" value="{{ old('name', $siswa->user->name) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Masukkan nama lengkap" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email Utama (Untuk Login)</label>
                    <input type="email" name="email" value="{{ old('email', $siswa->user->email) }}"
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

        {{-- Section: Informasi Profil --}}
        <div class="mb-10">
            <h5 class="text-sm font-bold text-primary uppercase tracking-widest mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">badge</span>
                Profil Akademik
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sekolah Asal --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Sekolah Asal</label>
                    <input type="text" name="sekolah" value="{{ old('sekolah', $siswa->sekolah) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Nama sekolah" required>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="Contoh: 10 SMA, 8 SMP" required>
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                        placeholder="08xxxxxxxxxx" required>
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Alamat</label>
                    <textarea name="alamat" rows="3"
                        class="w-full bg-surface-container-highest border-none rounded-xl p-3 text-sm font-medium text-on-surface focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all resize-none"
                        placeholder="Alamat lengkap siswa" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-4 pt-6 border-t border-surface-container-high">
            <button type="submit"
                class="flex items-center gap-2 bg-gradient-to-br from-primary to-primary-container text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 hover:scale-[1.02] active:scale-95">
                <span class="material-symbols-outlined">save</span>
                Perbarui Data Siswa
            </button>

            <a href="{{ route('admin.siswa.index') }}"
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
