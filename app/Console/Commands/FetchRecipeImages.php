<?php

namespace App\Console\Commands;

use App\Services\RecipeImageService;
use Illuminate\Console\Command;

class FetchRecipeImages extends Command
{
    protected $signature = 'recipes:fetch-images {--limit= : Jumlah maksimal resep yang diproses}';

    protected $description = 'Generate gambar resep via OpenAgentic AI untuk resep yang belum punya gambar';

    public function handle(RecipeImageService $service): int
    {
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;

        $this->info('Generating recipe images via OpenAgentic...');
        $this->newLine();

        $result = $service->generateForRecipes($limit);

        $this->info("Generated: {$result['generated']} gambar");
        $this->info("Remaining: {$result['remaining']} resep belum punya gambar");

        if (! empty($result['errors'])) {
            $this->newLine();
            $this->warn('Errors:');
            foreach ($result['errors'] as $error) {
                $this->line("  - {$error}");
            }
        }

        if ($result['remaining'] === 0) {
            $this->newLine();
            $this->info('Semua resep sudah punya gambar!');
        }

        return self::SUCCESS;
    }
}
