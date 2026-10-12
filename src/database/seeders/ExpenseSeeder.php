<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $budgets = Budget::all();

        if ($budgets->isEmpty()) {
            $budgets = collect([Budget::factory()->create(['user_id' => 1])]);
        }

        Expense::factory()
            ->count(15)
            ->state(fn() => [
                'budget_id' => $budgets->random()->id,
            ])
            ->create();
    }
}
