<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_register_page_exposes_labelled_password_fields(): void
    {
        $response = $this->get('/register');

        $response->assertOk()
            ->assertSee('for="name"', false)
            ->assertSee('for="email"', false)
            ->assertSee('for="password"', false)
            ->assertSee('for="password_confirmation"', false)
            ->assertSee('autocomplete="new-password"', false)
            ->assertSee('aria-describedby="password-hint', false)
            ->assertSee('id="password-match"', false)
            ->assertSee('aria-live="polite"', false);
    }

    public function test_failed_registration_shows_summary_and_preserves_input(): void
    {
        $this->from('/register')
            ->post('/register', [
                'name' => 'Ibu Uji',
                'email' => 'baru@example.test',
                'password' => 'pendek',
                'password_confirmation' => 'beda',
            ])
            ->assertRedirect('/register')
            ->assertSessionHasErrors('password');

        $page = $this->get('/register');

        $page->assertOk()
            ->assertSee('id="auth-error-summary"', false)
            ->assertSee('role="alert"', false)
            ->assertSee('id="password-error"', false)
            ->assertSee('value="Ibu Uji"', false)
            ->assertSee('value="baru@example.test"', false);
    }

    public function test_password_confirmation_must_match(): void
    {
        $this->from('/register')
            ->post('/register', [
                'name' => 'Ibu Uji',
                'email' => 'cocok@example.test',
                'password' => 'rahasia123',
                'password_confirmation' => 'rahasia123',
            ])
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', ['email' => 'cocok@example.test', 'role' => 'user']);
    }
}
