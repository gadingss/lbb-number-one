@extends('layouts.tutor')

@section('title', 'Riwayat Mengajar')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Riwayat Mengajar</h2>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasil</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($absensis as $key => $absensi)
            <tr>
                <td class="px-6 py-4">{{ $key + 1 }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">{{ $absensi->siswa->user->name }}</td>
                <td class="px-6 py-4">{{ $absensi->jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">
                    @if($absensi->status == 'hadir')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Hadir</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ ucfirst($absensi->status) }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm">
                    {{ $absensi->hasil_pertemuan ?? '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
