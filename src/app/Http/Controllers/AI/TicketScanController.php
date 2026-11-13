<?php

namespace App\Http\Controllers\AI;

use App\Ai\Agents\TicketScanner;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Ai\Files;

class TicketScanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:1240']
        ]);

        set_time_limit(120);

        /**
         * @var \Laravel\Ai\Responses\StructuredAgentResponse $response
         */
        $response = (new TicketScanner)
            ->prompt(
                'Lee este ticket de venta y extrae la información',
                attachments: [Files\Image::fromUpload($request->file('image'))],
                provider: 'openrouter',
                model: env('app.OPENROUTER_DEFAULT_MODEL_IMAGE', 'nvidia/nemotron-3.5-super-vl:free'),
                timeout: 120
            );

        if (empty($response['items'])) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudieron extraer los productos del ticket'
            ]);
        }

        return response()->json(
            $this->createExpenses($budget, $response['store'], $response['category'], $response['items'])
        );
    }

    /**
     * Registers multiple expenses associated with a budget and generates a summary message.
     */
    private function createExpenses(Budget $budget, string $store, string $category, array $items): array
    {
        $created = [];

        foreach ($items as $item) {
            $expense = Expense::create([
                'budget_id' => $budget->id,
                'name' => $store . ' - ' . $item['name'],
                'amount' => $item['amount'],
                'category' => $budget->isGeneral() ? $category : null,
            ]);

            $cat = $expense->category ? $expense->category->label() : 'Sin categoría';
            $created[] = "- {$expense->name}: \${$expense->amount} ({$cat})";
        }

        $total = array_sum(array_column($items, 'amount'));

        return [
            'success' => true,
            'message' => "Se registraron " . count($created) . " gastos del ticket:\n" .
                implode("\n", $created) .
                "\nTotal: \${$total}",
        ];
    }
}
