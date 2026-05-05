@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">
        Dashboard Siswa
    </h2>
    <p class="text-gray-500 text-sm mt-1">
        Selamat datang, 
        <span class="font-semibold text-indigo-600">
            {{ auth()->user()->name }}
        </span>
    </p>
</div>

{{-- ===================== PAKET AKTIF ===================== --}}
@if($paket)
<div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-xl shadow mb-8">
    <h3 class="text-lg font-semibold mb-2">Paket Aktif Anda</h3>
    <p class="text-3xl font-bold">{{ $paket->paket->nama_paket }}</p>
    <p class="text-blue-100 mt-1">{{ $paket->paket->mataPelajaran->nama_mapel ?? 'Mata Pelajaran Umum' }}</p>
    <div class="mt-4 flex flex-wrap gap-4">
        <span class="bg-white/20 px-3 py-1 rounded text-sm">
            Total Sesi: {{ $paket->paket->jumlah_pertemuan }}
        </span>
        <span class="bg-white/20 px-3 py-1 rounded text-sm">
            Telah Terpakai: {{ $sesiTerpakai }}
        </span>
        <span class="bg-white/30 px-3 py-1 rounded text-sm font-bold shadow-sm {{ $sisaSesi <= 2 ? 'text-red-200' : 'text-green-100' }}">
            Sisa Sesi: {{ $sisaSesi }}
        </span>
        <span class="bg-white/20 px-3 py-1 rounded text-sm">
            Rp {{ number_format($paket->paket->harga, 0, ',', '.') }}
        </span>
    </div>
</div>
@else
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Belum Memiliki Paket</h3>
    <p class="text-yellow-700 mb-4">Silakan pilih paket les terlebih dahulu</p>
    <a href="{{ route('siswa.paket.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded inline-block">
        Pilih Paket
    </a>
</div>
@endif

{{-- ===================== STATISTIK ===================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="bg-blue-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Total Pertemuan</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalPertemuan ?? 0 }}</p>
    </div>

    <div class="bg-green-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Bulan Ini</h3>
        <p class="text-3xl font-bold mt-2">{{ $pertemuanBulanIni ?? 0 }}</p>
    </div>

    <div class="bg-purple-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Total Pembayaran</h3>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}</p>
    </div>

    <div class="bg-orange-500 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Status Paket</h3>
        <p class="text-3xl font-bold mt-2">{{ $paket ? 'Aktif' : 'Tidak Aktif' }}</p>
    </div>

</div>

{{-- ===================== RIWAYAT PEMBAYARAN ===================== --}}
<h2 class="text-xl font-semibold mb-4 text-gray-700">
    Riwayat Pembayaran
</h2>

<div class="bg-white rounded-lg shadow overflow-hidden mb-10">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($riwayatPembayaran as $pembayaran)
            <tr>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">{{ $pembayaran->paket->nama_paket }}</td>
                <td class="px-6 py-4">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    @if($pembayaran->status == 'lunas')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Lunas</span>
                    @elseif($pembayaran->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Menunggu</span>
                    @elseif($pembayaran->status == 'gagal')
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada pembayaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===================== RIWAYAT LES ===================== --}}
<h2 class="text-xl font-semibold mb-4 text-gray-700">
    Riwayat Les
</h2>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($riwayatLes as $les)
            <tr>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($les->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">{{ $les->jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">{{ $les->tutor->user->name }}</td>
                <td class="px-6 py-4">
                    @if($les->status == 'hadir')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Hadir</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ ucfirst($les->status) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat les</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
