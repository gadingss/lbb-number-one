@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit Pembayaran</h2>
    <a href="{{ route('admin.pembayaran.index') }}" class="text-blue-600 hover:underline">
        &larr; Kembali ke Data Pembayaran
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select name="siswa_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ $pembayaran->siswa_id == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Paket Les</label>
                <select name="paket_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Paket</option>
                    @foreach($pakets as $paket)
                        <option value="{{ $paket->id }}" {{ $pembayaran->paket_id == $paket->id ? 'selected' : '' }}>
                            {{ $paket->nama_paket }} - {{ $paket->mataPelajaran->nama_mapel }} (Rp {{ number_format($paket->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran</label>
                <input type="number" name="jumlah" value="{{ $pembayaran->jumlah }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full border rounded px-3 py-2" required>
                    <option value="cash" {{ $pembayaran->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ $pembayaran->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="e-wallet" {{ $pembayaran->metode_pembayaran == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" value="{{ $pembayaran->tanggal_bayar }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="pending" {{ $pembayaran->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="lunas" {{ $pembayaran->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="gagal" {{ $pembayaran->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ $pembayaran->keterangan }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Update
            </button>
            <a href="{{ route('admin.pembayaran.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
