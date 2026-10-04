<?php

use App\Http\Controllers\Resources\BudgetController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('dashboard');

    Route::prefix('budgets')->name('budgets.')->group(function () {
        Route::get('/create', [BudgetController::class, 'create'])->name('create');
        Route::post('/create', [BudgetController::class, 'store'])->name('store');
        Route::get('/{budget}', [BudgetController::class, 'show'])->name('show');
        Route::get('/{budget}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{budget}', [BudgetController::class, 'update'])->name('update');
        Route::delete('/{budget}', [BudgetController::class, 'destroy'])->name('destroy');
    });
});
