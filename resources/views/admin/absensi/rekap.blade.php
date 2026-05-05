@extends('layouts.app')

@section('title', 'Rekap Kehadiran Tutor')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Rekap Kehadiran Tutor</h2>
    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Cetak Rekap
    </button>
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
            <label class="block text-sm text-gray-600 mb-1">Bulan</label>
            <input type="month" name="bulan" value="{{ request('bulan') }}" class="border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Filter
        </button>
    </form>
</div>

{{-- Rekap per Tutor --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @foreach($tutors as $tutor)
    @php
        $data = $rekap[$tutor->id] ?? ['total' => 0, 'hadir' => 0, 'tidak_hadir' => 0, 'izin' => 0, 'alpha' => 0];
    @endphp
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800">{{ $tutor->user->name }}</h3>
        <p class="text-sm text-gray-500 mb-4">{{ $tutor->keahlian }}</p>
        
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Pertemuan:</span>
                <span class="font-semibold">{{ $data['total'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Hadir:</span>
                <span class="font-semibold text-green-600">{{ $data['hadir'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tidak Hadir:</span>
                <span class="font-semibold text-red-600">{{ $data['tidak_hadir'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Izin:</span>
                <span class="font-semibold text-yellow-600">{{ $data['izin'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Alpha:</span>
                <span class="font-semibold text-gray-600">{{ $data['alpha'] }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Detail Riwayat --}}
<h3 class="text-xl font-semibold mb-4 text-gray-700">Riwayat Pertemuan</h3>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($absensis as $absensi)
            <tr>
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
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .shadow, .bg-white { box-shadow: none !important; }
}
</style>
@endsection
