<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Akses ditolak. Anda bukan administrator.');
        }

        return $next($request);
    }
}
