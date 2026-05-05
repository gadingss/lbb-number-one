@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 p-8 bg-white shadow-lg rounded-xl">

    <h2 class="text-2xl font-bold mb-6">Tambah Mata Pelajaran</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama</label>
            <input type="text" name="nama"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Deskripsi</label>
            <textarea name="deskripsi"
                      class="w-full border p-2 rounded"
                      rows="3"></textarea>
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>
@endsection