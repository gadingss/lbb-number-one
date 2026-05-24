<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    /**
     * Mengirim pesan WhatsApp menggunakan API Fonnte.
     *
     * @param string $target Nomor tujuan (contoh: 0812xxxx atau 62812xxxx)
     * @param string $message Pesan yang akan dikirim
     * @return array|bool Response dari Fonnte atau false jika gagal
     */
    public function sendMessage($target, $message)
    {
        if (empty($this->token)) {
            Log::warning('Fonnte token is missing. WhatsApp message not sent.', [
                'target' => $target,
                'message' => $message
            ]);
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Optional: Memastikan format nomor menggunakan kode negara Indonesia
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Fonnte API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'target' => $target,
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Fonnte API Exception', [
                'error' => $e->getMessage(),
                'target' => $target,
            ]);
            
            return false;
        }
    }
}
