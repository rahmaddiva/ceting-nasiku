<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteVisitTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_session_is_counted_once_per_day(): void
    {
        $this->get('/resep')->assertOk();

        $this->assertDatabaseHas('site_visits', [
            'visit_date' => now()->toDateString(),
            'visits' => 1,
        ]);

        // Permintaan berikutnya dalam sesi yang sama tidak menambah hitungan.
        $this->get('/resep')->assertOk();
        $this->get('/edukasi')->assertOk();

        $this->assertSame(1, (int) \DB::table('site_visits')->sum('visits'));
    }

    public function test_footer_shows_total_and_today_visits(): void
    {
        $this->get('/resep');

        // Kunjungan berikutnya (sesi berbeda) menambah hitungan.
        $this->flushSession();
        $this->get('/resep');

        $this->assertSame(2, (int) \DB::table('site_visits')->sum('visits'));

        $this->get('/edukasi')
            ->assertOk()
            ->assertSee('Total Pengunjung')
            ->assertSee('Hari Ini')
            ->assertSeeInOrder(['2', 'Total Pengunjung']);
    }
}
