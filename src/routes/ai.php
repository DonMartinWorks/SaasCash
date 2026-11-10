<?php

use App\Http\Controllers\AI\BudgetChatController;
use App\Http\Controllers\AI\TicketScanController;
use App\Http\Controllers\Resources\BudgetController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('dashboard');

    // Expenses
    Route::prefix('/budgets')->name('budgets.')->group(function () {
        Route::post('/{budget}/chat', [BudgetChatController::class, 'store'])->name('chat');
        Route::post('/{budget}/scan-ticket', [TicketScanController::class, 'store'])->name('scan-ticket');
    });
});
