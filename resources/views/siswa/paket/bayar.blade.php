@extends('layouts.siswa')

@section('title', 'Selesaikan Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Selesaikan Pembayaran</h2>
    <p class="text-gray-500">Silakan selesaikan pembayaran untuk paket yang Anda pilih.</p>
</div>

<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6 mb-6">
    <div class="border-b pb-4 mb-4">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Detail Pesanan</h3>
        <p class="text-gray-600 mb-2">Order ID: <span class="font-semibold">{{ $pembayaran->order_id }}</span></p>
        <p class="text-gray-600 mb-2">Paket: <span class="font-semibold">{{ $paket->nama_paket }}</span></p>
        <p class="text-gray-600 mb-2">Mata Pelajaran: <span class="font-semibold">{{ $paket->mataPelajaran->nama_mapel ?? '-' }}</span></p>
    </div>

    <div class="flex justify-between items-center mb-6">
        <span class="text-lg font-bold text-gray-700">Total Tagihan:</span>
        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
    </div>

    <div class="text-center">
        <button id="pay-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl">
            Bayar Sekarang
        </button>
        <p class="text-sm text-gray-500 mt-4">Anda akan diarahkan ke halaman pembayaran aman Midtrans.</p>
    </div>
</div>

<div class="max-w-2xl mx-auto text-center">
    <a href="{{ route('siswa.paket.index') }}" class="text-blue-600 hover:underline">
        &larr; Batal & Kembali ke Pilihan Paket
    </a>
</div>
@endsection

@section('scripts')
{{-- Midtrans Snap JS --}}
<script src="{{ config('midtrans.isProduction', env('MIDTRANS_IS_PRODUCTION')) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.clientKey', env('MIDTRANS_CLIENT_KEY')) }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result){
                window.location.href = "{{ route('siswa.dashboard') }}?payment=success";
            },
            // Optional
            onPending: function(result){
                window.location.href = "{{ route('siswa.dashboard') }}?payment=pending";
            },
            // Optional
            onError: function(result){
                alert("Pembayaran Gagal!");
                window.location.href = "{{ route('siswa.paket.index') }}";
            },
            onClose: function(){
                console.log('Customer closed the popup without finishing the payment');
            }
        });
    };
    
    // Auto-trigger payment popup on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('pay-button').click();
    });
</script>
@endsection
