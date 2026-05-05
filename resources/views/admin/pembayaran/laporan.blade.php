@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Laporan Pembayaran</h2>
    <div class="flex gap-2">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Cetak Laporan
        </button>
        <a href="{{ route('admin.pembayaran.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </div>
</div>

{{-- Filter Form --}}
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.pembayaran.laporan') }}" class="flex gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Filter
        </button>
        <a href="{{ route('admin.pembayaran.laporan') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
            Reset
        </a>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-green-600 text-white p-6 rounded-lg shadow">
        <h3 class="text-lg">Total Pendapatan (Lunas)</h3>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
    <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
        <h3 class="text-lg">Total Transaksi</h3>
        <p class="text-3xl font-bold mt-2">{{ $pembayarans->count() }}</p>
    </div>
    <div class="bg-yellow-600 text-white p-6 rounded-lg shadow">
        <h3 class="text-lg">Pending</h3>
        <p class="text-3xl font-bold mt-2">{{ $pembayarans->where('status', 'pending')->count() }}</p>
    </div>
</div>

{{-- Tabel Laporan --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full" id="table-laporan">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
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
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Print Styles --}}
<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .shadow, .bg-white { box-shadow: none !important; }
}
</style>
@endsection
