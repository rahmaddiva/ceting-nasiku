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

Peran:
- Bertindak sebagai Ahli Gizi dan Dokter Spesialis Gizi Klinik (Sp.GK)
- Memberi edukasi berbasis ilmu gizi yang akurat, jelas, dan dapat dipraktikkan
- Membantu pencegahan stunting melalui gizi, pola asuh, dan PHBS

Cakupan jawaban:
- Resep dan menu bergizi untuk bayi, balita, ibu hamil, dan ibu menyusui
- Edukasi stunting: penyebab, dampak, pencegahan
- Kebutuhan gizi dan panduan praktis (bukan diagnosis klinis personal)
- Bahan makanan lokal yang terjangkau
- Tips memasak dan pola makan seimbang

Gaya penulisan (wajib):
1. Bahasa Indonesia baku, profesional, tetap ramah dan mudah dipahami
2. Struktur rapi: judul singkat jika perlu, poin berurutan, paragraf pendek
3. Istilah medis/gizi boleh dipakai, selalu diikuti penjelasan awam singkat
4. Emoji minimal (paling banyak 1–2 per jawaban, atau tidak sama sekali)
5. Hindari bahasa kasual berlebihan, slang, dan format berantakan
6. Jika panjang, gunakan daftar bernomor atau bullet yang konsisten

Aturan konten:
1. Prioritaskan bahan lokal dan hemat
2. Jika menyebut resep: cantumkan porsi/usia, bahan, langkah singkat, dan catatan gizi
3. Di luar topik stunting/gizi/kesehatan ibu-anak: arahkan kembali dengan sopan
4. Jangan mendiagnosis penyakit atau menggantikan konsultasi tatap muka; untuk kasus serius sarankan ke dokter/ahli gizi
5. Jawaban harus akurat; jika data tidak pasti, sampaikan dengan hati-hati
PROMPT;

    /**
     * Kirim pesan ke OpenAgentic dan kembalikan balasan.
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'history' => 'nullable|array',
            'history.*.role' => 'required|string|in:user,assistant',
            'history.*.content' => 'required|string',
        ]);

        $apiKey = env('OPENAGENTIC_API_KEY');

        if (! $apiKey) {
            return response()->json(['error' => 'API key tidak ditemukan.'], 500);
        }

        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt],
        ];

        if (! empty($request->history)) {
            foreach ($request->history as $item) {
                $messages[] = [
                    'role' => $item['role'],
                    'content' => $item['content'],
                ];
            }
        }

        $messages[] = [
            'role' => 'user',
            'content' => $request->message,
        ];

        // ponytail: fallback chain, add more models if needed
        $models = ['claude-sonnet-4.5', 'deepseek-v4-flash'];

        try {
            $response = null;

            foreach ($models as $model) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(60)->post('https://openagentic.id/api/v1/chat/completions', [
                    'model' => $model,
                    'messages' => $messages,
                    'max_tokens' => 1000,
                ]);

                if ($response->successful()) {
                    break;
                }

                Log::warning('OpenAgentic model failed, trying next', [
                    'model' => $model,
                    'status' => $response->status(),
                ]);
            }

            if ($response->failed()) {
                Log::error('OpenAgentic API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'error' => 'Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi.',
                ], 500);
            }

            // OpenAgentic appends SSE trailer "data: [DONE]" after JSON
            $raw = preg_replace('/data:\s*\[DONE\]\s*$/', '', $response->body());
            $data = json_decode(trim($raw), true);
            $choice = $data['choices'][0]['message'] ?? null;

            if (! $choice) {
                Log::error('OpenAgentic unexpected body', ['body' => $response->body()]);

                return response()->json(['error' => 'Tidak ada respons dari AI.'], 500);
            }

            return response()->json([
                'reply' => $choice['content'] ?? '',
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: '.$e->getMessage());

            return response()->json([
                'error' => 'Koneksi ke AI bermasalah. Pastikan jaringan internet tersedia.',
            ], 500);
        }
    }
}
