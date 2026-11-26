<?php

use App\Http\Controllers\Resources\ExpenseController;
use App\Http\Controllers\Resources\BudgetController;
use App\Http\Controllers\Resources\SubscriptionCheckoutController;
use App\Http\Controllers\Resources\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('dashboard');

    Route::prefix('/budgets')->name('budgets.')->group(function () {
        Route::get('/create', [BudgetController::class, 'create'])->name('create');
        Route::post('/create', [BudgetController::class, 'store'])->name('store');
        Route::get('/{budget}', [BudgetController::class, 'show'])->name('show');
        Route::get('/{budget}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{budget}', [BudgetController::class, 'update'])->name('update');
        Route::delete('/{budget}', [BudgetController::class, 'destroy'])->name('destroy');
    });

    // Expenses
    Route::post('/{budget}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/{budget}/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/{budget}/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/subscription-checkout/{plan}', [SubscriptionCheckoutController::class, 'store'])
        ->name('subscription.checkout')->whereIn('plan', ['monthly', 'yearly']);

    Route::view('/billing/success', 'billing.success')->name('billing.success');
    Route::view('/billing/cancel', 'billing.cancel')->name('billing.cancel');

    Route::get('/plans', function () {
        return Inertia::render('Pro/Plans', [
            'prices' => [
                'monthly' => (int) config('services.stripe.price_view_monthly'),
                'yearly' => (int) config('services.stripe.price_view_yearly'),
            ],
        ]);
    })->name('plans');

    Route::get('/subscription', [SubscriptionController::class, 'show'])->name('subscription.manage');

    Route::post('/subscription/swap/{plan}', [SubscriptionController::class, 'swap'])
        ->name('subscription.swap')
        ->whereIn('plan', ['monthly', 'yearly']);

    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resume', [SubscriptionController::class, 'resume'])->name('subscription.resume');
});
