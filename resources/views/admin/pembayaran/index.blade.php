@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Data Pembayaran</h2>
    <a href="{{ route('admin.pembayaran.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        + Tambah Pembayaran
    </a>
</div>

{{-- Filter --}}
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="flex gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="lunas">Lunas</option>
                <option value="gagal">Gagal</option>
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Filter
        </button>
        <a href="{{ route('admin.pembayaran.laporan') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Lihat Laporan
        </a>
    </form>
</div>

{{-- Tabel Pembayaran --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($pembayarans as $key => $pembayaran)
            <tr>
                <td class="px-6 py-4">{{ $key + 1 }}</td>
                <td class="px-6 py-4">{{ $pembayaran->siswa->user->name }}</td>
                <td class="px-6 py-4">{{ $pembayaran->paket->nama_paket }}</td>
                <td class="px-6 py-4">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                <td class="px-6 py-4">{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">
                    @if($pembayaran->status == 'lunas')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Lunas</span>
                    @elseif($pembayaran->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Gagal</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.pembayaran.edit', $pembayaran->id) }}" 
                       class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                    <form action="{{ route('admin.pembayaran.destroy', $pembayaran->id) }}" 
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
