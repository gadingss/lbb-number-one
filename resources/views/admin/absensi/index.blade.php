@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Data Absensi & Kehadiran</h2>
    <div class="flex gap-2">
        <a href="{{ route('admin.absensi.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + Catat Absensi
        </a>
        <a href="{{ route('admin.absensi.rekap') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
            Rekap Tutor
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="flex gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tutor</label>
            <select name="tutor_id" class="border rounded px-3 py-2">
                <option value="">Semua Tutor</option>
                @foreach($tutors as $tutor)
                    <option value="{{ $tutor->id }}">{{ $tutor->user->name }}</option>
                @endforeach
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
        <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Semua</option>
                <option value="hadir">Hadir</option>
                <option value="tidak_hadir">Tidak Hadir</option>
                <option value="izin">Izin</option>
                <option value="alpha">Alpha</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Filter
        </button>
    </form>
</div>

{{-- Tabel Absensi --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($absensis as $key => $absensi)
            <tr>
                <td class="px-6 py-4">{{ $key + 1 }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">{{ $absensi->tutor->user->name }}</td>
                <td class="px-6 py-4">{{ $absensi->siswa->user->name }}</td>
                <td class="px-6 py-4">{{ $absensi->jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">
                    @if($absensi->status == 'hadir')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Hadir</span>
                    @elseif($absensi->status == 'tidak_hadir')
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Tidak Hadir</span>
                    @elseif($absensi->status == 'izin')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Izin</span>
                    @else
                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Alpha</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.absensi.edit', $absensi->id) }}" 
                       class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
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
@endsection
