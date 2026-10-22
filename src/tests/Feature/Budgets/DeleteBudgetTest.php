<?php

use App\Models\Budget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

it('allows the owner to delete a budget', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($user)->create();

    $response = $this->actingAs($user)->delete(route('budgets.destroy', $budget));

    $response->assertRedirect(route('dashboard'));

    $response->assertSessionHas('success', 'Presupuesto eliminado exitosamente.');

    $this->assertSoftDeleted('budgets', [
        'id' => $budget->id,
    ]);
});

it('does not allow guests to delete budgets', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($user)->create();

    $response = $this->delete(route('budgets.destroy', $budget));

    $response->assertRedirect(route('login'));

    $this->assertDatabaseHas('budgets', [
        'id' => $budget->id,
    ]);
});

it('does not allow unverified users to delete budgets', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $budget = Budget::factory()->for($user)->create();

    $response = $this->actingAs($user)->delete(route('budgets.destroy', $budget));

    $response->assertRedirect(route('verification.notice'));

    $this->assertDatabaseHas('budgets', [
        'id' => $budget->id,
    ]);
});

it('does not allow other users to delete budgets', function () {
    $owner = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $otherUser = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($owner)->create([
        'name' => 'El super Presupuesto'
    ]);

    $response = $this->actingAs($otherUser)->delete(route('budgets.destroy', $budget));

    $response->assertForbidden();
    $response->assertStatus(403);
    $response->assertSee('No tienes los permisos para eliminar este presupuesto.');

    $this->assertDatabaseHas('budgets', [
        'id' => $budget->id,
        'name' => 'El super Presupuesto'
    ]);
});

it('handles exceptions gracefully and logs the error when deleting a budget fails', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($user)->create();

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function ($message) {
            return str_contains($message, 'Error al eliminar el presupuesto');
        });

    Budget::deleting(function () {
        throw new Exception('Simulación de fallo crítico en base de datos');
    });

    $response = $this->actingAs($user)->delete(route('budgets.destroy', $budget));

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Ocurrió un error al intentar eliminar el presupuesto. Inténtalo de nuevo más tarde.');

    $this->assertDatabaseHas('budgets', [
        'id' => $budget->id,
    ]);
});
