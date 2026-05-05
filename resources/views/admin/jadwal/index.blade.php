@extends('layouts.app')

@section('title', 'Data Jadwal')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Data Jadwal Tutor</h2>
    <a href="{{ route('admin.jadwal.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        + Tambah Jadwal
    </a>
</div>

{{-- Tabel Jadwal --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Mulai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Selesai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($jadwals as $key => $jadwal)
            <tr>
                <td class="px-6 py-4">{{ $key + 1 }}</td>
                <td class="px-6 py-4">{{ $jadwal->tutor->user->name ?? '-' }}</td>
                <td class="px-6 py-4">{{ $jadwal->siswa->user->name ?? 'Belum Diatur' }}</td>
                <td class="px-6 py-4">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">{{ $jadwal->hari }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" 
                       class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                    <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" 
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
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data jadwal</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
