<?php

namespace App\Http\Controllers\AI;

use App\Ai\Agents\BudgetAssistant;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
#[Middleware('verified')]
class BudgetChatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget)
    {
        $messages = $request->input('messages', []);

        $lastMessage = collect($messages)->last();

        $prompt = collect(data_get($lastMessage, 'parts', []))
            ->where('type', 'text')
            ->pluck('text')
            ->implode(' ')
            ?: data_get($lastMessage, 'content', '');


        $agent = new BudgetAssistant;

        $agent->budgetId = $budget->id;
        $agent->hasCategories = $budget->isGeneral();

        if ($budget->isGoal()) {
            $agent->budgetContext = "Este presupuesto es de tipo Meta/Objetivo llamado '{$budget->name}' con un monto total de \${$budget->amount}. Los gastos NO tienen categorías, solo nombre y monto.";
        } else {
            $agent->budgetContext = "Este presupuesto es de tipo General llamado '{$budget->name}' con un monto total de \${$budget->amount}. Los gastos tienen nombre, monto y categoría.";
        }

        return $agent->stream(
            $prompt,
            provider: 'openrouter',
            // model: 'poolside/laguna-xs.2b:free',
            // model: 'thinkingmachines/inkling:free',
            // model: 'google/gemma-4-26b-a4b-it:free',
            // model: 'xingchen-agi/xing4.0-29b-a4b:free',
            model: 'nvidia/nemotron-3.5-super-vl:free', // <-- This is the model that works best for this use case
            // model: 'nvidia/nemotron-3-ultra-550b-a55b:free',
            // model: 'cohere/north-mini-code:free'
        )->usingVercelDataProtocol();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
