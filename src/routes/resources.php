<?php

use App\Http\Controllers\Resources\BudgetController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [BudgetController::class, 'index'])->name('dashboard');
