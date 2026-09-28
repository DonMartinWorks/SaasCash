<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

#[Middleware('auth')]
#[Middleware('verified')]
class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.index');
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
        $validated = $request->validated();

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
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
