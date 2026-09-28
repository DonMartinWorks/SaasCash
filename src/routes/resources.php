<?php

use App\Http\Controllers\Resources\BudgetController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard')->group(function() {
    Route::get('/', [BudgetController::class, 'index'])->name('dashboard');
    Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets/create', [BudgetController::class, 'store'])->name('budgets.store');
});
