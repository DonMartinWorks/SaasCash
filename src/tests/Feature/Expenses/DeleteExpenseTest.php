<?php

use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

it('allows the expense owner to delete an expense', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($user)->create([
        'type' => 'general',
    ]);

    $expense = Expense::factory()->for($budget)->create([
        'name' => 'Supermercado',
    ]);

    $response = $this->actingAs($user)->delete(route('expenses.destroy', [$budget, $expense]));
    $response->assertRedirect(route('budgets.show', $budget));

    $this->assertSoftDeleted('expenses', [
        'id' => $expense->id
    ]);
});

it('does not allow guests to delete expenses', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($user)->create([
        'type' => 'general',
    ]);

    $expense = Expense::factory()->for($budget)->create();

    $response = $this->delete(route('expenses.destroy', [$budget, $expense]));

    $response->assertRedirect(route('login'));
    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id
    ]);
});

it('does not allow unverified users to delete expenses', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $budget = Budget::factory()->for($user)->create([
        'type' => 'general',
    ]);

    $expense = Expense::factory()->for($budget)->create();

    $response = $this->actingAs($user)->delete(route('expenses.destroy', [$budget, $expense]));

    $response->assertRedirect(route('verification.notice'));
    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id
    ]);
});

it('does not allow other users to delete expenses they do not own', function () {
    $owner = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $otherUser = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($owner)->create([
        'type' => 'general',
    ]);

    $expense = Expense::factory()->for($budget)->create([
        'name' => 'Supermercado',
    ]);

    $response = $this->actingAs($otherUser)->delete(route('expenses.destroy', [$budget, $expense]));
    $response->assertForbidden();

    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id
    ]);
});

it('handles exceptions gracefully and logs the error when deleting an expense fails', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $budget = Budget::factory()->for($user)->create([
        'type' => 'general',
    ]);

    $expense = Expense::factory()->for($budget)->create([
        'name' => 'Supermercado',
    ]);

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function ($message) {
            return str_contains($message, 'Error al eliminar el gasto');
        });

    Expense::deleting(function () {
        throw new Exception('Simulación de error crítico en la base de datos');
    });

    $response = $this->actingAs($user)->delete(route('expenses.destroy', [$budget, $expense]));

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Ocurrió un error al intentar eliminar el gasto. Inténtalo de nuevo más tarde.');

    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id
    ]);
});
