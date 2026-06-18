<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_are_protected_and_admin_can_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        User::create(['name' => 'Admin', 'email' => 'admin@test.local', 'password' => Hash::make('secret123'), 'is_admin' => true]);
        $this->post('/admin/login', ['email' => 'admin@test.local', 'password' => 'secret123'])
            ->assertRedirect('/admin');
        $this->assertAuthenticated();
        $this->get('/admin')->assertOk()->assertSee('Dashboard');
    }

    public function test_non_admin_cannot_login_to_admin_panel(): void
    {
        User::create(['name' => 'Customer', 'email' => 'user@test.local', 'password' => Hash::make('secret123'), 'is_admin' => false]);
        $this->post('/admin/login', ['email' => 'user@test.local', 'password' => 'secret123'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
