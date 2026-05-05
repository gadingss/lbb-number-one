@extends('layouts.siswa')

@section('title', 'Pilih Paket Les')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Pilih Paket Les</h2>
    <p class="text-gray-500">Pilih paket les yang sesuai dengan kebutuhan Anda</p>
</div>

{{-- Paket Aktif --}}
@if($paketAktif)
<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
    <h3 class="font-semibold text-green-800">✓ Anda sudah memiliki paket aktif</h3>
    <p class="text-green-700">{{ $paketAktif->paket->nama_paket }}</p>
</div>
@endif

{{-- Daftar Paket --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($pakets as $paket)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $paket->nama_paket }}</h3>
        <p class="text-gray-600 mb-4">{{ $paket->deskripsi }}</p>
        
        <div class="space-y-2 mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">Mata Pelajaran:</span>
                <span class="font-medium">{{ $paket->mataPelajaran->nama_mapel ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Jumlah Pertemuan:</span>
                <span class="font-medium">{{ $paket->jumlah_pertemuan }}x</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Durasi:</span>
                <span class="font-medium">{{ $paket->durasi_pertemuan }} menit/pertemuan</span>
            </div>
        </div>

        <div class="border-t pt-4 mb-4">
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
        </div>

        <form action="{{ route('siswa.paket.pesan') }}" method="POST">
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
                Pilih Paket
            </button>
        </form>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <p class="text-gray-500">Belum ada paket tersedia</p>
    </div>
    @endforelse
</div>
@endsection
