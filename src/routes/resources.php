<?php

use App\Http\Controllers\Resources\ExpenseController;
use App\Http\Controllers\Resources\BudgetController;
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
    Route::post('/subscription-checkout/{plan}', function (Request $request, string $plan) {
        $prices = [
            'monthly' => config('services.stripe.price_ai_monthly'),
            'yearly' => config('services.stripe.price_ai_yearly')
        ];

        abort_unless(isset($prices[$plan]), 404, 'Plan no válido');

        $checkout = $request->user()
            ->newSubscription('default', $prices[$plan])
            // ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('billing.success'),
                'cancel_url' => route('billing.cancel')
            ]);

        return Inertia::location($checkout->url);
    })->name('subscription.checkout')->whereIn('plan', ['monthly', 'yearly']);

    Route::view('/billing/success', 'billing.success')->name('billing.success');
    Route::view('/billing/cancel', 'billing.cancel')->name('billing.cancel');
});
