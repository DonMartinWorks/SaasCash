<?php

namespace Database\Factories;

use App\Enums\ExpenseCategory;
use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'budget_id' => Budget::factory(),
            'name' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 10, 1000), // Montos entre 10 y 1000
            'category' => $this->faker->randomElement(ExpenseCategory::cases()),
        ];
    }
}
