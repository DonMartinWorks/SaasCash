<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('shows the login screen', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Iniciar Sesión')
        ->assertSeeInOrder([
            'Correo Electrónico',
            'Contraseña',
        ]);
});

it('logs in a verified user successfully', function () {
    User::factory()->create([
        'email' => 'test@test.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);

    $this->post(route('login.store'), [
        'email' => 'test@test.com',
        'password' => 'password',
    ])
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticated();
});

it('remembers a user when remember me checkbox is checked', function () {
    $user = User::factory()->create([
        'email' => 'test@test.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);

    $this->post(route('login.store'), [
        'email' => 'test@test.com',
        'password' => 'password',
        'remember' => 'on',
    ])
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
    expect($user->fresh()->remember_token)->not->toBeNull();
});

it('logs out an authenticated user successfully', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

it('fails login with invalid password', function () {
    User::factory()->create([
        'email' => 'test@test.com',
        'password' => Hash::make('password'),
    ]);

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'test@test.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);

    $this->assertGuest();
});

it('fails login if user does not exist', function () {
    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'matt.damon@laravel.com',
            'password' => 'password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);

    $this->assertGuest();
});

it('redirects authenticated users away from login screen', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('login'))
        ->assertRedirect(route('dashboard'));
});

it('validates required fields when submitting empty login form', function () {
    $this->from(route('login'))
        ->post(route('login.store'), [])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors(['email', 'password']);

    $this->assertGuest();
});

it('retains old email input on login failure', function () {
    User::factory()->create([
        'email' => 'juan@test.com',
        'password' => Hash::make('password123'),
    ]);

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'juan@test.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasInput('email', 'juan@test.com')
        ->assertSessionHasErrors('email')
        ->assertSessionHas('_old_input', function (array $oldInput) {
            return ! array_key_exists('password', $oldInput);
        });
});
