<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Test suite tidak boleh menyentuh database pengembangan, walau shell
        // mengekspor DB_CONNECTION/DB_DATABASE atau .env berisi MySQL.
        if ($app->environment('testing')) {
            $app['config']->set('database.default', 'sqlite');
            $app['config']->set('database.connections.sqlite.database', ':memory:');
            $app['config']->set('cache.default', 'array');
            $app['config']->set('session.driver', 'array');
        }

        return $app;
    }
}
