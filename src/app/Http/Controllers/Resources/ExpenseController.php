<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Throwable;

#[Middleware('auth')]
#[Middleware('verified')]
class ExpenseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request, Budget $budget)
    {
        Gate::authorize('create', [Expense::class, $budget]);

        $budget->expenses()->create($request->validated());

        return redirect()->route('budgets.show', $budget)->with('success', 'Gasto creado exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update', 'expense')]
    public function update(ExpenseRequest $request, Budget $budget, Expense $expense)
    {
        $expense->update($request->validated());

        return redirect()->route('budgets.show', $budget)->with('success', 'Gasto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete', 'expense')]
    public function destroy(Budget $budget, Expense $expense)
    {
        try {
            $expense->delete();

            return redirect()
                ->route('budgets.show', $budget)
                ->with('success', 'Gasto eliminado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error al eliminar el gasto: ' . $e->getMessage(), [
                'budget_id'  => $budget->id,
                'expense_id' => $expense->id,
                'exception'  => $e
            ]);

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al intentar eliminar el gasto. Inténtalo de nuevo más tarde.');
        }
    }
}
