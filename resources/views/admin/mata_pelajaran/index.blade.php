@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 p-8 bg-white shadow-lg rounded-xl">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Data Mata Pelajaran</h2>

        <a href="{{ route('admin.mata-pelajaran.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">
            + Tambah Mata Pelajaran
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3">No</th>
                <th class="border p-3">Nama</th>
                <th class="border p-3">Deskripsi</th>
                <th class="border p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mataPelajarans as $mapel)
                <tr>
                    <td class="border p-3">{{ $loop->iteration }}</td>
                    <td class="border p-3">{{ $mapel->nama }}</td>
                    <td class="border p-3">{{ $mapel->deskripsi ?? '-' }}</td>
                    <td class="border p-3 space-x-2">
                        <a href="{{ route('admin.mata-pelajaran.edit', $mapel->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('admin.mata-pelajaran.destroy', $mapel->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border p-3 text-center text-gray-500">
                        Belum ada data mata pelajaran
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection