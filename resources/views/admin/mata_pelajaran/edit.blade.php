@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 p-8 bg-white shadow-lg rounded-xl">

    <h2 class="text-2xl font-bold mb-6">Edit Mata Pelajaran</h2>

    <form action="{{ route('admin.mata-pelajaran.update', $mata_pelajaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama</label>
            <input type="text" name="nama"
                   value="{{ $mata_pelajaran->nama }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Deskripsi</label>
            <textarea name="deskripsi"
                      class="w-full border p-2 rounded"
                      rows="3">{{ $mata_pelajaran->deskripsi }}</textarea>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>
@endsection