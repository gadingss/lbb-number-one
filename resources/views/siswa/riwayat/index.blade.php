@extends('layouts.siswa')

@section('title', 'Riwayat Les')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Riwayat Les</h2>
    <p class="text-gray-500">Riwayat kegiatan belajar mengajar Anda</p>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-lg shadow overflow-hidden overflow-x-auto">
    <table class="w-full min-w-[700px]">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Tutor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Konfirmasi Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasil</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($riwayats as $key => $riwayat)
            <tr>
                <td class="px-6 py-4">{{ $key + 1 }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">{{ $riwayat->jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">{{ $riwayat->tutor->user->name }}</td>
                <td class="px-6 py-4">
                    @if($riwayat->status == 'hadir')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Hadir</span>
                    @elseif($riwayat->status == 'izin')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Izin</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Alpha</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($riwayat->konfirmasi_siswa == 'pending')
                        <form action="{{ route('siswa.riwayat.konfirmasi', $riwayat->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="konfirmasi_siswa" value="hadir">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">Hadir</button>
                        </form>
                        <form action="{{ route('siswa.riwayat.konfirmasi', $riwayat->id) }}" method="POST" class="mt-1">
                            @csrf
                            <input type="hidden" name="konfirmasi_siswa" value="tidak_hadir">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Tidak</button>
                        </form>
                    @elseif($riwayat->konfirmasi_siswa == 'hadir')
                        <span class="text-green-600 font-semibold text-sm">Dikonfirmasi Hadir</span>
                    @else
                        <span class="text-red-600 font-semibold text-sm">Dikonfirmasi Tidak Hadir</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm">
                    {{ $riwayat->hasil_pertemuan ?? '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat les</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
