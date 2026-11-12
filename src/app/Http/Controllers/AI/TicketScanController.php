<?php

namespace App\Http\Controllers\AI;

use App\Ai\Agents\TicketScanner;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;
use Laravel\Ai\Files;

class TicketScanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget)
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
    }
}
