<?php

use App\Http\Controllers\AI\BudgetChatController;
use App\Http\Controllers\Resources\BudgetController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('dashboard');

    Route::prefix('/budgets')->name('budgets.')->group(function () {
        // Expenses
        Route::post('/{budget}/chat', [BudgetChatController::class, 'store'])->name('chat');
    });
});
