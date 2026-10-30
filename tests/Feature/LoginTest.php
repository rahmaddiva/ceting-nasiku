<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_exposes_labelled_fields_for_assistive_tech(): void
    {
        $response = $this->get('/login');

        $response->assertOk()
            ->assertSee('for="email"', false)
            ->assertSee('for="password"', false)
            ->assertSee('autocomplete="username"', false)
            ->assertSee('autocomplete="current-password"', false)
            ->assertSee('aria-label="Tampilkan password"', false);
    }

    public function test_failed_login_shows_summary_inline_error_and_keeps_email(): void
    {
        $this->from('/login')
            ->post('/login', ['email' => 'salah@example.com', 'password' => 'keliru'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $page = $this->get('/login');

        $page->assertOk()
            // ringkasan error dapat difokuskan pembaca layar
            ->assertSee('id="auth-error-summary"', false)
            ->assertSee('role="alert"', false)
            // pesan tampil di ringkasan dan di bawah field
            ->assertSee('Email atau password salah.')
            ->assertSee('id="email-error"', false)
            ->assertSee('aria-invalid="true"', false)
            // email tidak hilang setelah gagal
            ->assertSee('value="salah@example.com"', false);
    }
}
