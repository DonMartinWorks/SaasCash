<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

#[Middleware('auth')]
#[Middleware('verified')]
class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $budgets = Auth::user()->budgets()->get();

        return view('dashboard.index', [
            'budgets' => $budgets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('resources.budget.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetRequest $request): RedirectResponse
    {
        $budget = Auth::user()->budgets()->create($request->validated());

        return redirect()->route('dashboard')->with('success', 'Presupuesto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update', 'budget')]
    public function edit(Budget $budget): View
    {
        return view('resources.budget.edit', [
            'budget' => $budget
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update', 'budget')]
    public function update(BudgetRequest $request, Budget $budget)
    {
        $budget->update($request->validated());

        return redirect()->route('dashboard')->with('success', 'Presupuesto actualizado exitosamente');;
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete', 'budget')]
    public function destroy(Budget $budget): RedirectResponse
    {
        try {
            $budget->delete();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Presupuesto eliminado exitosamente.');
        } catch (Throwable $e) {
            Log::error('Error al eliminar el presupuesto: ' . $e->getMessage(), [
                'budget_id' => $budget->id,
                'exception' => $e
            ]);

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al intentar eliminar el presupuesto. Inténtalo de nuevo más tarde.');
        }
    }
}
