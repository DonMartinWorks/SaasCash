<?php

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

it('shows the registration screen', function () {
    $this->get(route('register'))
        ->assertOk()
        ->assertSee('Registrarme')
        ->assertSeeInOrder([
            'Nombre',
            'Correo Electrónico',
            'Contraseña',
            'Repetir Contraseña',
        ]);
});

it('registers a new unverified user and dispatches registered event', function () {
    Event::fake();

    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => 'pass.Poto123',
        'password_confirmation' => 'pass.Poto123',
    ])
        ->assertRedirect(route('verification.notice'));

    $user = User::where('email', 'test@test.com')->first();

    expect($user)->not()->toBeNull();
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@test.com');
    expect($user->hasVerifiedEmail())->toBeFalse();

    Event::assertDispatched(Registered::class);
});

it('validates required fields when request body is empty', function () {
    $this->post(route('register.store'), [])
        ->assertSessionHasErrors([
            'name' => 'El nombre es obligatorio.',
            'email' => 'El correo electrónico es obligatorio.',
            'password' => 'La contraseña es obligatoria.',
        ]);
});

it('prevents duplicate email addresses', function () {
    User::factory()->create([
        'email' => 'test@test.com',
    ]);

    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => 'pass.Poto123',
        'password_confirmation' => 'pass.Poto123',
    ])
        ->assertSessionHasErrors([
            'email' => 'Este correo electrónico ya está registrado.',
        ]);
});

it('sends verification email notification after registration', function () {
    Notification::fake();

    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => 'pass.Poto123',
        'password_confirmation' => 'pass.Poto123',
    ]);

    $user = User::where('email', 'test@test.com')->first();

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('verifies user from signed verification link', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    $this->actingAs($user)
        ->get($verificationUrl)
        ->assertRedirect(route('dashboard'));

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('redirects authenticated users away from registration screen', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('register'))
        ->assertRedirect(route('dashboard'));
});

it('forbids verification when signed URL has an invalid signature or modified parameters', function () {
    $user = User::factory()->unverified()->create();

    $validUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    $tamperedUrl = $validUrl . 'tampered';

    $this->actingAs($user)
        ->get($tamperedUrl)
        ->assertForbidden();

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

it('throttles email verification resend requests after limit is reached', function () {
    $user = User::factory()->unverified()->create();

    for ($i = 0; $i < 6; $i++) {
        $this->actingAs($user)
            ->post(route('verification.resend'))
            ->assertRedirect();
    }

    $this->actingAs($user)
        ->post(route('verification.resend'))
        ->assertStatus(429);
});

it('redirects already verified user to dashboard when hitting verification notice or verify link', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('verification.notice'))
        ->assertRedirect(route('dashboard'));

    $this->actingAs($user)
        ->post(route('verification.resend'))
        ->assertRedirect(route('dashboard'));
});