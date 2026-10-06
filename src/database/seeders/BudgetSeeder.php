<?php

namespace Database\Seeders;

use App\Models\Budget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Budget::factory()->create([
            'user_id' => 1,
            'name' => 'Presupuesto ABC',
            'amount' => 1000.00,
            'type' => 'general'
        ]);

        Budget::factory()->create([
            'user_id' => 1,
            'name' => 'Presupuesto XYZ',
            'amount' => 1000.00,
            'type' => 'goal'
        ]);
    }
}
