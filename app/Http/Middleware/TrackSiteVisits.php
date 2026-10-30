<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisits
{
    /**
     * Catat satu kunjungan per sesi per hari, lalu bagikan jumlahnya
     * ke seluruh view (dipakai footer). Penulisan DB hanya terjadi
     * sekali per sesi per hari, tidak per permintaan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $today = now()->toDateString();

            if (session('last_visit_date') !== $today) {
                DB::table('site_visits')->where('visit_date', $today)->increment('visits');
                DB::table('site_visits')->insertOrIgnore([
                    'visit_date' => $today,
                    'visits' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                session(['last_visit_date' => $today]);
                Cache::forget('site_visits_stats');
            }

            $stats = Cache::remember('site_visits_stats', 60, function () use ($today) {
                return [
                    'total' => (int) DB::table('site_visits')->sum('visits'),
                    'today' => (int) (DB::table('site_visits')->where('visit_date', $today)->value('visits') ?? 0),
                ];
            });

            View::share('visitStats', $stats);
        } catch (\Throwable $e) {
            report($e);
        }

        return $response;
    }
}
