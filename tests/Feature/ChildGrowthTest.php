<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\User;
use Database\Seeders\WhoGrowthStandardSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildGrowthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(WhoGrowthStandardSeeder::class);
    }

    public function test_user_can_register(): void
    {
        $response = $this->get('/register');

        $response->assertOk()->assertSee('Buat Akun Baru');

        $this->post('/register', [
            'name' => 'Ibu Siti',
            'email' => 'siti@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('users', ['email' => 'siti@example.com', 'role' => 'user']);
        $this->assertAuthenticated();
    }

    public function test_guest_is_redirected_from_profil(): void
    {
        $this->get('/profil')->assertRedirect('/login');
        $this->get('/profil/anak/create')->assertRedirect('/login');
    }

    public function test_user_can_add_child_and_measurement_with_status(): void
    {
        $user = User::create([
            'name' => 'Ibu Siti',
            'email' => 'siti@example.com',
            'password' => bcrypt('rahasia123'),
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->post('/profil/anak', [
                'name' => 'Budi',
                'gender' => 'male',
                'birth_date' => '2022-01-15',
            ])
            ->assertRedirect(route('profil.index'));

        $child = Child::where('name', 'Budi')->first();
        $this->assertNotNull($child);
        $this->assertEquals($user->id, $child->user_id);

        // Pengukuran: umur ±24 bulan, TB 80 cm (< -2SD boys 24m = 81.0) -> stunting
        $this->actingAs($user)
            ->post(route('profil.children.measurements.store', $child), [
                'measured_at' => '2024-01-20',
                'weight_kg' => '11.5',
                'height_cm' => '80',
                'note' => 'Pengukuran rutin',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('child_measurements', [
            'child_id' => $child->id,
            'weight_kg' => 11.5,
            'height_cm' => 80,
        ]);

        $response = $this->actingAs($user)->get(route('profil.children.show', $child));

        $response->assertOk()
            ->assertSee('Pendek (Stunting)')
            ->assertSee('Z-score')
            ->assertSee('80')
            ->assertSee('Kurva Pertumbuhan WHO');
    }

    public function test_user_cannot_access_other_users_child(): void
    {
        $owner = User::create(['name' => 'Pemilik', 'email' => 'a@test.dev', 'password' => bcrypt('x'), 'role' => 'user']);
        $other = User::create(['name' => 'Lain', 'email' => 'b@test.dev', 'password' => bcrypt('x'), 'role' => 'user']);

        $child = Child::create([
            'user_id' => $owner->id,
            'name' => 'Anak A',
            'gender' => 'female',
            'birth_date' => '2022-01-15',
        ]);

        $this->actingAs($other)
            ->get(route('profil.children.show', $child))
            ->assertForbidden();

        $this->actingAs($other)
            ->post(route('profil.children.measurements.store', $child), [
                'measured_at' => '2024-01-20',
                'weight_kg' => '10',
            ])
            ->assertForbidden();
    }

    public function test_measurement_requires_at_least_one_value(): void
    {
        $user = User::create(['name' => 'Ibu Siti', 'email' => 'siti@example.com', 'password' => bcrypt('x'), 'role' => 'user']);
        $child = Child::create([
            'user_id' => $user->id,
            'name' => 'Budi',
            'gender' => 'male',
            'birth_date' => '2022-01-15',
        ]);

        $this->actingAs($user)
            ->from(route('profil.children.show', $child))
            ->post(route('profil.children.measurements.store', $child), [
                'measured_at' => '2024-01-20',
            ])
            ->assertSessionHasErrors('weight_kg');
    }

    public function test_growth_chart_loads_standards_with_a_single_query(): void
    {
        $user = User::create(['name' => 'Ibu Siti', 'email' => 'siti@example.com', 'password' => bcrypt('x'), 'role' => 'user']);
        $child = Child::create([
            'user_id' => $user->id,
            'name' => 'Budi',
            'gender' => 'male',
            'birth_date' => '2022-01-15',
        ]);

        $child->measurements()->create(['measured_at' => '2024-01-20', 'weight_kg' => 11.5, 'height_cm' => 80]);

        \Illuminate\Support\Facades\DB::enableQueryLog();

        $this->actingAs($user)->get(route('profil.children.show', $child))->assertOk();

        $standardQueries = collect(\Illuminate\Support\Facades\DB::getQueryLog())
            ->filter(fn ($q) => str_contains($q['query'], 'growth_standards'));

        // Standar WHO (240 baris) harus diambil sekali, bukan per bulan x level z.
        $this->assertCount(1, $standardQueries);
    }
}
