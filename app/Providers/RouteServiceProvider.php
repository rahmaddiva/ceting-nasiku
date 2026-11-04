<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Halaman tujuan setelah autentikasi (lihat RedirectIfAuthenticated).
     */
    public const HOME = '/';

    /**
     * Daftarkan route aplikasi. Tidak ada route API: aplikasi ini
     * server-rendered Blade sepenuhnya.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
