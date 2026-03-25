<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * System prompt khusus untuk asisten stunting CETING NASIKU.
     */
    private string $systemPrompt = <<<'PROMPT'
Kamu adalah NASI (Narasumber Ahli Stunting Indonesia), asisten AI dari aplikasi CETING NASIKU (Cegah Stunting Melalui Pemenuhan Gizi untuk Keluarga Unggul).

Tugasmu adalah membantu menjawab pertanyaan seputar:
- Resep makanan bergizi seimbang untuk mencegah stunting (bayi, balita, ibu hamil, ibu menyusui)
- Edukasi pencegahan stunting (gizi, pola asuh, PHBS, masa kehamilan)
- Penyebab dan dampak stunting
- Rekomendasi bahan makanan lokal yang mudah didapat dan hemat
- Kalkulator gizi sederhana dan penjelasan kebutuhan nutrisi
- Tips memasak makanan bergizi untuk anak

Aturan:
1. Selalu jawab dalam Bahasa Indonesia yang ramah, jelas, dan mudah dipahami oleh ibu rumah tangga
2. Gunakan poin-poin atau daftar jika membutuhkan penjelasan panjang
3. Jika pertanyaan di luar topik stunting/gizi/resep, arahkan kembali dengan ramah
4. Sertakan emoji relevan sesekali agar jawaban terasa akrab
5. Jika menyebutkan resep, sertakan bahan-bahan dan langkah memasak singkat
6. Prioritaskan bahan makanan lokal yang terjangkau
PROMPT;

    /**
     * Kirim pesan ke OpenRouter dan kembalikan balasan.
     */
    public function send(Request $request)
    {
        $request->validate([
            'message'   => 'required|string|max:2000',
            'history'   => 'nullable|array',
            'history.*.role'    => 'required|string|in:user,assistant',
            'history.*.content' => 'required|string',
        ]);

        $apiKey = env('OPEN_ROUTER');

        if (!$apiKey) {
            return response()->json(['error' => 'API key tidak ditemukan.'], 500);
        }

        // Susun array messages: system + history + pesan baru
        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt],
        ];

        // Tambahkan riwayat percakapan (multi-turn)
        if (!empty($request->history)) {
            foreach ($request->history as $item) {
                $msg = [
                    'role'    => $item['role'],
                    'content' => $item['content'],
                ];
                // Sertakan reasoning_details jika ada (untuk lanjutan chain-of-thought)
                if (!empty($item['reasoning_details'])) {
                    $msg['reasoning_details'] = $item['reasoning_details'];
                }
                $messages[] = $msg;
            }
        }

        // Tambahkan pesan user saat ini
        $messages[] = [
            'role'    => 'user',
            'content' => $request->message,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
                'HTTP-Referer'  => url('/'),
                'X-Title'       => 'CETING NASIKU Chatbot',
            ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model'     => 'nvidia/nemotron-3-super-120b-a12b:free',
                'messages'  => $messages,
                'reasoning' => ['enabled' => true],
            ]);

            if ($response->failed()) {
                Log::error('OpenRouter API Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return response()->json([
                    'error' => 'Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi.'
                ], 500);
            }

            $data    = $response->json();
            $choice  = $data['choices'][0]['message'] ?? null;

            if (!$choice) {
                return response()->json(['error' => 'Tidak ada respons dari AI.'], 500);
            }

            return response()->json([
                'reply'            => $choice['content'] ?? '',
                'reasoning_details'=> $choice['reasoning_details'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'error' => 'Koneksi ke AI bermasalah. Pastikan jaringan internet tersedia.'
            ], 500);
        }
    }
}
