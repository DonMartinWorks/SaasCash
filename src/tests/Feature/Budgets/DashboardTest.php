<?php

use App\Models\Budget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

it('shows empty state when the user has no budgets', function () {
    $user = User::factory()->create([
        'email_verified_at' =>now()
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));
    $response->assertOk();
    $response->assertSee('No Hay Presupuestos.');
    $response->assertSee('Comienza creando uno');
});

it('only shows the authenticated user budgets', function () {
    $userOne = User::factory()->create([
        'email_verified_at' =>now()
    ]);

    $userTwo = User::factory()->create([
        'email_verified_at' =>now()
    ]);

    Budget::factory()->for($userOne)->create([
        'name' => 'Mi Presupesto 1'
    ]);

    Budget::factory()->for($userTwo)->create([
        'name' => 'Mi Presupesto A'
    ]);

    $response = $this->actingAs($userOne)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Mi Presupesto 1');
    $response->assertDontSee('Mi Presupesto A');
});
