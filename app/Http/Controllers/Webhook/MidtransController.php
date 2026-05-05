<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            Log::error('Midtrans Callback Invalid Signature Key', ['request' => $request->all()]);
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        
        $pembayaran = Pembayaran::where('order_id', $orderId)->first();
        
        if (!$pembayaran) {
            Log::error('Midtrans Callback Order Not Found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $pembayaran->update(['status' => 'lunas']);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $pembayaran->update(['status' => 'gagal']);
        } elseif ($transactionStatus == 'pending') {
            $pembayaran->update(['status' => 'pending']);
        }

        Log::info('Midtrans Callback Success', ['order_id' => $orderId, 'status' => $transactionStatus]);
        return response()->json(['message' => 'Callback processed successfully']);
    }
}
